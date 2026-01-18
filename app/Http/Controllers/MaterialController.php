<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('name')->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $material = Material::create($request->all());

        // Create initial stock log
        StockLog::create([
            'material_id' => $material->id,
            'type' => 'in',
            'quantity' => $material->current_stock,
            'previous_stock' => 0,
            'new_stock' => $material->current_stock,
            'description' => 'Initial stock',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Material created successfully.');
    }

    public function show(Material $material)
    {
        $material->load('stockLogs.createdBy');
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'minimum_stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $material->update($request->all());

        return redirect()->route('materials.index')
            ->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Material deleted successfully.');
    }

    public function addStock(Request $request, Material $material)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        $previousStock = $material->current_stock;
        $newStock = $previousStock + $request->quantity;

        try {
            DB::beginTransaction();

            // Update material stock
            $material->update(['current_stock' => $newStock]);

            // Create stock log
            StockLog::create([
                'material_id' => $material->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'description' => $request->description ?? 'Stock added',
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return back()->with('success', 'Stock added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error adding stock: ' . $e->getMessage());
        }
    }

    public function useStock(Request $request, Material $material)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        $previousStock = $material->current_stock;

        if ($previousStock < $request->quantity) {
            return back()->with('error', 'Insufficient stock. Current stock: ' . $previousStock . ' ' . $material->unit);
        }

        $newStock = $previousStock - $request->quantity;

        try {
            DB::beginTransaction();

            // Update material stock
            $material->update(['current_stock' => $newStock]);

            // Create stock log
            StockLog::create([
                'material_id' => $material->id,
                'type' => 'out',
                'quantity' => $request->quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'description' => $request->description ?? 'Stock used',
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return back()->with('success', 'Stock used successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error using stock: ' . $e->getMessage());
        }
    }
}
