<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\ProductPriceOption; // Import the new model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['productType', 'category'])->orderBy('name');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('productType', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->paginate(10)->appends($request->only('search'));

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
            'price' => 'nullable|numeric|min:0', // Changed to nullable
            'unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'specifications' => 'array',
            'specifications.*.name' => 'required|string|max:100',
            'specifications.*.value' => 'required|string|max:100',
            'specifications.*.additional_price' => 'required|numeric|min:0',
            'price_options' => 'array', // New validation for price options
            'price_options.*.label' => 'required|string|max:255',
            'price_options.*.price' => 'required|numeric|min:0',
        ]);

        $productType = ProductType::find($validatedData['product_type_id']);
        $validatedData['category_id'] = $productType->category_id;

        $product = Product::create($validatedData);

        // Process Product Specifications (existing logic)
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

        // Process Product Price Options (new logic)
        if ($request->has('price_options')) {
            foreach ($request->price_options as $option) {
                ProductPriceOption::create([
                    'product_id' => $product->id,
                    'label' => $option['label'],
                    'price' => $option['price'],
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function show(Product $product)
    {
        $product->load('productType.category', 'specifications', 'priceOptions'); // Load price options
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        $product->load('specifications', 'priceOptions'); // Load price options
        return view('products.edit', compact('product', 'categories', 'productTypes'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0', // Changed to nullable
            'unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'specifications' => 'array',
            'specifications.*.name' => 'required|string|max:100',
            'specifications.*.value' => 'required|string|max:100',
            'specifications.*.additional_price' => 'required|numeric|min:0',
            'price_options' => 'array', // New validation for price options
            'price_options.*.label' => 'required|string|max:255',
            'price_options.*.price' => 'required|numeric|min:0',
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

        // Delete existing price options
        ProductPriceOption::where('product_id', $product->id)->delete();

        // Create new price options
        if ($request->has('price_options')) {
            foreach ($request->price_options as $option) {
                ProductPriceOption::create([
                    'product_id' => $product->id,
                    'label' => $option['label'],
                    'price' => $option['price'],
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