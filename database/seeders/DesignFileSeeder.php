<?php

namespace Database\Seeders;

use App\Models\DesignFile;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DesignFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItems = OrderItem::all();

        if ($orderItems->isEmpty()) {
            $this->call(OrderItemSeeder::class);
            $orderItems = OrderItem::all();
        }

        // Ensure there are order items
        if ($orderItems->isEmpty()) {
            echo "No order items found or created. Cannot seed design files.\n";
            return;
        }

        // Create a dummy file for demonstration
        if (!Storage::exists('public/design_files/dummy_design.pdf')) {
            Storage::put('public/design_files/dummy_design.pdf', 'This is a dummy design file content.');
        }
        $dummyFilePath = 'design_files/dummy_design.pdf';

        foreach ($orderItems as $orderItem) {
                            DesignFile::firstOrCreate([
                                'order_item_id' => $orderItem->id,
                                'file_path' => $dummyFilePath,
                                'file_name' => 'Design_' . $orderItem->id . '.pdf',
                                'file_type' => 'PDF', // Add a default file_type
                                'status' => 'approved', // or 'pending', 'rejected'
                                'notes' => 'Desain awal disetujui pelanggan.',
                                'uploaded_by' => 1, // Assuming user with ID 1 exists (admin)
                            ]);        }
    }
}