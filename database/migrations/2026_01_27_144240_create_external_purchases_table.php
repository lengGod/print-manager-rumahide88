<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('external_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('source_shop');
            $table->decimal('price', 15, 2);
            $table->date('purchase_date');
            $table->enum('payment_status', ['lunas', 'belum lunas'])->default('belum lunas');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_purchases');
    }
};
