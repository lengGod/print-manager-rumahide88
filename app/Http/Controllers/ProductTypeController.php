<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTypes = ProductType::with('category')->latest()->paginate(10);
        return view('product-types.index', compact('productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product-types.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:product_types',
            'description' => 'nullable|string',
        ]);

        ProductType::create($request->all());

        return redirect()->route('product-types.index')
            ->with('success', 'Tipe Produk berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        return view('product-types.show', compact('productType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductType $productType)
    {
        $categories = Category::all();
        return view('product-types.edit', compact('productType', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:product_types,name,' . $productType->id,
            'description' => 'nullable|string',
        ]);

        $productType->update($request->all());

        return redirect()->route('product-types.index')
            ->with('success', 'Tipe Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return redirect()->route('product-types.index')
            ->with('success', 'Tipe Produk berhasil dihapus.');
    }
}
