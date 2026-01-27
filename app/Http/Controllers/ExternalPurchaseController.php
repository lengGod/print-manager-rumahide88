<?php

namespace App\Http\Controllers;

use App\Models\ExternalPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = ExternalPurchase::with('createdBy')
            ->orderBy('purchase_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('external-purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('external-purchases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'source_shop' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'payment_status' => 'required|in:lunas,belum lunas',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        ExternalPurchase::create($data);

        return redirect()->route('external-purchases.index')
            ->with('success', 'Catatan pembelian eksternal berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalPurchase $externalPurchase)
    {
        return view('external-purchases.edit', compact('externalPurchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalPurchase $externalPurchase)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'source_shop' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'payment_status' => 'required|in:lunas,belum lunas',
            'notes' => 'nullable|string',
        ]);

        $externalPurchase->update($request->all());

        return redirect()->route('external-purchases.index')
            ->with('success', 'Catatan pembelian eksternal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalPurchase $externalPurchase)
    {
        $externalPurchase->delete();

        return redirect()->route('external-purchases.index')
            ->with('success', 'Catatan pembelian eksternal berhasil dihapus.');
    }
}
