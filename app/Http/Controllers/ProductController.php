<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['productType', 'category'])->orderBy('name')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('products.create', compact('categories', 'productTypes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'specifications' => 'array',
            'specifications.*.name' => 'required|string|max:100',
            'specifications.*.value' => 'required|string|max:100',
            'specifications.*.additional_price' => 'required|numeric|min:0',
        ]);

        $productType = ProductType::find($validatedData['product_type_id']);
        $validatedData['category_id'] = $productType->category_id;

        $product = Product::create($validatedData);

        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'name' => $spec['name'],
                    'value' => $spec['value'],
                    'additional_price' => $spec['additional_price'],
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function show(Product $product)
    {
        $product->load('productType.category', 'specifications');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        $product->load('specifications');
        return view('products.edit', compact('product', 'categories', 'productTypes'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'specifications' => 'array',
            'specifications.*.name' => 'required|string|max:100',
            'specifications.*.value' => 'required|string|max:100',
            'specifications.*.additional_price' => 'required|numeric|min:0',
        ]);

        $productType = ProductType::find($validatedData['product_type_id']);
        $validatedData['category_id'] = $productType->category_id;

        $product->update($validatedData);

        // Delete existing specifications
        ProductSpecification::where('product_id', $product->id)->delete();

        // Create new specifications
        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'name' => $spec['name'],
                    'value' => $spec['value'],
                    'additional_price' => $spec['additional_price'],
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
