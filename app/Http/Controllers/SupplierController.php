<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }
    public function create()
    {
        return view('suppliers.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);
        Supplier::create($request->all());
        return redirect()->route('suppliers.index')
            ->with('success','Supplier Created Successfully');
    }
    public function show(Supplier $supplier)
    {
        $supplier->load('purchases.items.product');
        return view('suppliers.show', compact('supplier'));
    }
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')
            ->with('success','Supplier Updated Successfully');
    }
     public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success','Supplier Deleted');
    }
}