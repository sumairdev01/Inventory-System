<?php
namespace App\Http\Controllers;
use App\Mail\PurchaseOrderMail;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'invoice_number' => 'INV-'.time(),
                'purchase_date' => now(),
                'total_amount' => 0,
                'paid_amount' => 0,
                'status' => 'completed',          
                'notes' => $request->notes,        
            ]);
            $total = 0;
            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $item['quantity'] * $item['price'];
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);
                $product->quantity += $item['quantity'];
                $product->save();
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item['quantity'],
                    'note' => 'Purchase #'.$purchase->invoice_number,
                ]);
                $total += $subtotal;
            }
            $purchase->update(['total_amount' => $total]);
            DB::commit();
            if ($purchase->supplier && $purchase->supplier->email) {
                Mail::to($purchase->supplier->email)->send(new PurchaseOrderMail($purchase));
            }
            return redirect()->route('purchases.index')
                ->with('success', 'Purchase Completed');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }
    public function edit(string $id)
    {
    }
    public function update(Request $request, string $id)
    {
    }
    public function destroy(string $id)
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);
        DB::beginTransaction();
        try {
            foreach ($purchase->items as $item) {
                if ($item->product) {
                    $product = $item->product;
                    $product->quantity -= $item->quantity;
                    if ($product->quantity < 0) {
                        $product->quantity = 0;
                    }
                    $product->save();
                    StockTransaction::create([
                        'product_id' => $product->id,
                        'type' => 'out',
                        'quantity' => $item->quantity,
                        'note' => 'Purchase deleted / stock reverted',
                    ]);
                }
            }
            $purchase->items()->delete();
            $purchase->delete();
            DB::commit();
            return back()->with('success', 'Purchase deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}