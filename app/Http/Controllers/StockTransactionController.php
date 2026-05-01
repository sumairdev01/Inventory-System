<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    /**
     * Store a new stock transaction (Stock In / Stock Out)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out',
            'quantity'   => 'required|integer|min:1',
            'note'       => 'nullable|string'
        ]);

        // Use database transaction for safety
        DB::beginTransaction();

        try {

            $product = Product::findOrFail($request->product_id);

            // ❌ Prevent negative stock
            if ($request->type === 'out' && $request->quantity > $product->quantity) {
                return back()->with('error', 'Not enough stock available!');
            }

            // ✅ Create stock transaction record
            StockTransaction::create([
                'product_id' => $product->id,
                'type'       => $request->type,
                'quantity'   => $request->quantity,
                'note'       => $request->note
            ]);

            // ✅ Update product quantity
            if ($request->type === 'in') {
                $product->quantity += $request->quantity;
            } else {
                $product->quantity -= $request->quantity;
            }

            $product->save();

            DB::commit();

            return back()->with('success', 'Stock updated successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Something went wrong. Try again.');
        }
    }
    public function create(Product $product)
    {
        return view('stock.create', compact('product'));
    }
    public function historyIndex()
    {
        $transactions = StockTransaction::with('product')->latest()->paginate(15);
        return view('stock.history_index', compact('transactions'));
    }

    /**
     * Show stock history for a product
     */
    public function history($productId)
    {
        $product = Product::with('transactions')
            ->findOrFail($productId);

        return view('stock.history', compact('product'));
    }
}
