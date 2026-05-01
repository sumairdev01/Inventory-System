<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        // Load categories with their products
        // Include search filter if provided
        $categories = Category::with(['products' => function($query) use ($request) {
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            $query->orderBy('name', 'asc');
        }])->get();

        // Filter out categories that have 0 products if searching
        if ($request->filled('search')) {
            $categories = $categories->filter(function($category) {
                return $category->products->count() > 0;
            });
        }

        // Global Stats calculation
        $allProductsQuery = Product::query();
        if ($request->filled('search')) {
            $allProductsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        $totalProductsCount = $allProductsQuery->count();
        $totalValue = $allProductsQuery->sum('price'); // Needs multiplication by quantity if real total, but kept original pricing sum logic
        $lowStockCount = $allProductsQuery->where('quantity', '<=', 5)->count();

        return view('products.index', compact(
            'categories',
            'totalProductsCount',
            'totalValue',
            'lowStockCount'
        ));
    }

    /**
     * Show create product form
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => 0,
            'alert_threshold' => $request->alert_threshold ?? 5,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Product Added Successfully');
    }

    /**
     * Show edit product form
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update existing product
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'alert_threshold' => $request->alert_threshold ?? $product->alert_threshold,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }
}
