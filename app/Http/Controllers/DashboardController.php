<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use App\Models\Sale;
use App\Models\Purchase;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalStock = Product::sum('quantity');
        $lowStockCount = Product::where('quantity', '<=', 5)->count();

        //  Sales & Purchases Summary
        $totalSales = Sale::sum('total_amount');
        $totalPurchases = Purchase::sum('total_amount');
        $salesCount = Sale::count();
        $purchasesCount = Purchase::count();

        $recentTransactions = StockTransaction::with('product')->latest()->take(10)->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalStock',
            'lowStockCount',
            'recentTransactions',
            'totalSales',
            'totalPurchases',
            'salesCount',
            'purchasesCount'
        ));
    }
}
