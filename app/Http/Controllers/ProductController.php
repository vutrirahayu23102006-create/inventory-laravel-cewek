<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'latest');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($sort === 'name', fn ($query) => $query->orderBy('name'))
            ->when($sort === 'stock', fn ($query) => $query->orderBy('stock'))
            ->when($sort === 'price', fn ($query) => $query->orderBy('price'))
            ->when($sort === 'latest', fn ($query) => $query->latest())
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStock = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
        $totalStock = Product::sum('stock');

        return view('products.index', compact(
            'products',
            'search',
            'sort',
            'totalProducts',
            'totalCategories',
            'lowStock',
            'totalStock'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore($product->id),
            ],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
