<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Kolom ID unik
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key ke products
            $table->integer('quantity'); // Jumlah produk yang dibeli
            $table->decimal('total_price', 10, 2); // Total harga
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Status transaksi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
