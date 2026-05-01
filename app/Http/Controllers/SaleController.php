<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockTransaction;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockMail;

class SaleController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index()
    {
        // Load customer + products for each sale
        $sales = Sale::with('customer', 'items.product')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $customers = Customer::all();
        return view('sales.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Create main Sale
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'total_amount' => 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'status' => 'pending',
            ]);

            $total = 0;

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Stock check
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                $price = $product->price;
                $subtotal = $price * $item['quantity'];

                // Save Sale Item
                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // Reduce Stock
                $product->quantity -= $item['quantity'];
                $product->save();

                // Stock Transaction
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'note' => 'Sale created',
                ]);

                // Low stock email
                if ($product->quantity <= $product->alert_threshold) {
                    $users = User::pluck('email')->toArray();
                    $admin = User::first();
                    if (!empty($users) && $admin) {
                        Mail::to($users)->send(new LowStockMail($product, $admin));
                    }
                }

                $total += $subtotal;
            }

            // Update total & status
            $paid = $request->paid_amount ?? 0;
            $status = 'pending';
            if ($paid >= $total && $total > 0) {
                $status = 'paid';
            } elseif ($paid > 0) {
                $status = 'partial';
            }

            $sale->update([
                'total_amount' => $total,
                'status' => $status,
            ]);

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sale failed: ' . $e->getMessage());
        }
    }

    /**
     * Show a specific sale (optional, for detail page).
     */
    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }

    /**
     * Remove the specified sale.
     */
    public function destroy(Sale $sale)
    {
        DB::beginTransaction();

        try {
            // Restore product stock
            foreach ($sale->items as $item) {
                $product = $item->product;
                $product->quantity += $item->quantity;
                $product->save();

                // Record stock return
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item->quantity,
                    'note' => 'Sale deleted / stock returned',
                ]);
            }

            // Delete sale & items
            $sale->items()->delete();
            $sale->delete();

            DB::commit();
            return back()->with('success', 'Sale deleted successfully!');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}