<?php
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration
  {
      public function up(): void
      {
          Schema::table('products', function (Blueprint $table) {
              // Tambahkan kolom category_id
              $table->foreignId('category_id')->nullable()->after('stock')->constrained('categories')->onDelete('set null');
              // Hapus kolom category lama (jika ada)
              if (Schema::hasColumn('products', 'category')) {
                  $table->dropColumn('category');
              }
          });
      }

      public function down(): void
      {
          Schema::table('products', function (Blueprint $table) {
              // Kembalikan kolom category lama (jika diperlukan)
              $table->string('category')->nullable()->after('stock');
              // Hapus kolom category_id
              $table->dropForeign(['category_id']);
              $table->dropColumn('category_id');
          });
      }
  };
