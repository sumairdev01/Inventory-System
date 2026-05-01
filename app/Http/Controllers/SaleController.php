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
    public function index()
    {
        $sales = Sale::with('customer', 'items.product')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $customers = Customer::all();
        return view('sales.create', compact('products', 'customers'));
    }
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
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'total_amount' => 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'status' => 'pending',
            ]);
            $total = 0;
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }
                $price = $product->price;
                $subtotal = $price * $item['quantity'];
                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
                $product->quantity -= $item['quantity'];
                $product->save();
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'note' => 'Sale created',
                ]);
                if ($product->quantity <= $product->alert_threshold) {
                    $users = User::pluck('email')->toArray();
                    $admin = User::first();
                    if (!empty($users) && $admin) {
                        Mail::to($users)->send(new LowStockMail($product, $admin));
                    }
                }
                $total += $subtotal;
            }
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
    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }
    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            foreach ($sale->items as $item) {
                $product = $item->product;
                $product->quantity += $item->quantity;
                $product->save();
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item->quantity,
                    'note' => 'Sale deleted / stock returned',
                ]);
            }
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