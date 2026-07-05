<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('store_categories')->onDelete('cascade')->after('store_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('store_category_id')->nullable()->constrained('store_categories')->nullOnDelete()->after('category_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('store_category_id')->nullable()->constrained('store_categories')->nullOnDelete()->after('category_id');
        });

        Schema::table('rental_items', function (Blueprint $table) {
            $table->foreignId('store_category_id')->nullable()->constrained('store_categories')->nullOnDelete()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('rental_items', function (Blueprint $table) {
            $table->dropForeign(['store_category_id']);
            $table->dropColumn('store_category_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['store_category_id']);
            $table->dropColumn('store_category_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['store_category_id']);
            $table->dropColumn('store_category_id');
        });

        Schema::table('store_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
