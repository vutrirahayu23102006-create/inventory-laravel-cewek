<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalStock = Product::sum('stock');

        $lowStock = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalStock',
            'lowStock',
            'latestProducts'
        ));
    }
}
