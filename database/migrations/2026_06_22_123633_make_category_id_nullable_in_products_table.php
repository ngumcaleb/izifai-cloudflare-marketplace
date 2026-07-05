<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NULL');

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Set any null category_ids to a default category before making it NOT NULL
        $defaultCategoryId = DB::table('categories')->value('id');
        if ($defaultCategoryId) {
            DB::table('products')->whereNull('category_id')->update(['category_id' => $defaultCategoryId]);
        }

        DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NOT NULL');

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
};
