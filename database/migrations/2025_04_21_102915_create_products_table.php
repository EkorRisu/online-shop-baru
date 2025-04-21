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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Kolom ID unik
            $table->string('name'); // Nama produk
            $table->text('description'); // Deskripsi produk
            $table->decimal('price', 10, 2); // Harga produk (desimal)
            $table->integer('stock'); // Jumlah stok
            $table->string('image')->nullable(); // Path gambar (opsional)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
