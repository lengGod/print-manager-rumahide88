<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom status dari ENUM ke VARCHAR
        DB::statement("ALTER TABLE orders ALTER COLUMN status DROP DEFAULT");
        DB::statement("ALTER TABLE orders ALTER COLUMN status TYPE VARCHAR(255) USING status::VARCHAR");
        DB::statement("ALTER TABLE orders ALTER COLUMN status SET DEFAULT 'Menunggu Desain'");

        // Ubah kolom payment_status dari ENUM ke VARCHAR
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_status DROP DEFAULT");
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_status TYPE VARCHAR(255) USING payment_status::VARCHAR");
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_status SET DEFAULT 'unpaid'");
    }

    public function down(): void
    {
        // Kembalikan ke tipe awal jika diperlukan (opsional)
        DB::statement("ALTER TABLE orders ALTER COLUMN status TYPE VARCHAR(255)");
        DB::statement("ALTER TABLE orders ALTER COLUMN payment_status TYPE VARCHAR(255)");
    }
};
