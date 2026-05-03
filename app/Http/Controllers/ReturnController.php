<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    // --- Sales Returns ---
    
    public function salesIndex()
    {
        $returns = SaleReturn::with(['sale.customer', 'product'])->latest()->paginate(10);
        return view('returns.sales.index', compact('returns'));
    }

    public function createSaleReturn(Sale $sale)
    {
        $sale->load('items.product', 'customer');
        return view('returns.sales.create', compact('sale'));
    }

    public function storeSaleReturn(Request $request, Sale $sale)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string',
        ]);

        // Check if quantity being returned is valid (not more than sold)
        $soldItem = $sale->items()->where('product_id', $request->product_id)->first();
        if (!$soldItem || $request->quantity > $soldItem->quantity) {
            return back()->with('error', 'Invalid return quantity.');
        }

        DB::transaction(function () use ($request, $sale) {
            // 1. Create Return Record
            SaleReturn::create([
                'sale_id' => $sale->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'refund_amount' => $request->refund_amount,
                'reason' => $request->reason,
                'return_date' => now(),
            ]);

            // 2. Update Product Stock (Increase)
            $product = Product::find($request->product_id);
            $product->increment('quantity', $request->quantity);

            // 3. Log Stock Transaction
            StockTransaction::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'type' => 'in',
                'note' => "Sale Return (Sale #{$sale->id})",
            ]);
        });

        return redirect()->route('returns.sales.index')->with('success', 'Sale return processed successfully.');
    }

    // --- Purchase Returns ---

    public function purchasesIndex()
    {
        $returns = PurchaseReturn::with(['purchase.supplier', 'product'])->latest()->paginate(10);
        return view('returns.purchases.index', compact('returns'));
    }

    public function createPurchaseReturn(Purchase $purchase)
    {
        $purchase->load('items.product', 'supplier');
        return view('returns.purchases.create', compact('purchase'));
    }

    public function storePurchaseReturn(Request $request, Purchase $purchase)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string',
        ]);

        // Check if quantity being returned is valid (not more than purchased and in stock)
        $purchasedItem = $purchase->items()->where('product_id', $request->product_id)->first();
        $product = Product::find($request->product_id);

        if (!$purchasedItem || $request->quantity > $purchasedItem->quantity) {
            return back()->with('error', 'Invalid return quantity (cannot return more than purchased).');
        }

        if ($request->quantity > $product->quantity) {
            return back()->with('error', 'Insufficient stock to perform this return.');
        }

        DB::transaction(function () use ($request, $purchase, $product) {
            // 1. Create Return Record
            PurchaseReturn::create([
                'purchase_id' => $purchase->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'refund_amount' => $request->refund_amount,
                'reason' => $request->reason,
                'return_date' => now(),
            ]);

            // 2. Update Product Stock (Decrease)
            $product->decrement('quantity', $request->quantity);

            // 3. Log Stock Transaction
            StockTransaction::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'type' => 'out',
                'note' => "Purchase Return (Purchase #{$purchase->id})",
            ]);
        });

        return redirect()->route('returns.purchases.index')->with('success', 'Purchase return processed successfully.');
    }
}
