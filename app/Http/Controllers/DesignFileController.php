<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\DesignFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DesignFileController extends Controller
{
    public function index()
    {
        $designFiles = DesignFile::with('orderItem.order.customer', 'uploadedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('design-files.index', compact('designFiles'));
    }

    public function create(OrderItem $orderItem)
    {
        return view('design-files.create', compact('orderItem'));
    }

    public function store(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,cdr|max:10240', // Max 10MB
            'notes' => 'nullable|string',
        ]);

        // Get the latest revision number for this order item
        $latestRevision = DesignFile::where('order_item_id', $orderItem->id)
            ->max('revision') ?? 0;

        $newRevision = $latestRevision + 1;

        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('design_files', $fileName, 'public');

        // Create design file record
        DesignFile::create([
            'order_item_id' => $orderItem->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => strtoupper($file->getClientOriginalExtension()),
            'revision' => $newRevision,
            'status' => 'uploaded',
            'notes' => $request->notes,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('orders.show', $orderItem->order_id)
            ->with('success', 'Design file uploaded successfully.');
    }

    public function show(DesignFile $designFile)
    {
        $designFile->load('orderItem.order.customer', 'uploadedBy', 'approvedBy');

        return view('design-files.show', compact('designFile'));
    }

    public function approve(Request $request, DesignFile $designFile)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $designFile->update([
            'status' => 'approved',
            'notes' => $request->notes,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Design file approved successfully.');
    }

    public function reject(Request $request, DesignFile $designFile)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $designFile->update([
            'status' => 'rejected',
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Design file rejected successfully.');
    }

    public function download(DesignFile $designFile)
    {
        return Storage::disk('public')->download($designFile->file_path, $designFile->file_name);
    }

    public function destroy(DesignFile $designFile)
    {
        // Delete file from storage
        Storage::disk('public')->delete($designFile->file_path);

        // Delete record
        $designFile->delete();

        return back()->with('success', 'Design file deleted successfully.');
    }
}
