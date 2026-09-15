<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['products', 'services', 'rental_items'] as $table) {
            if (Schema::hasColumn($table, 'store_category_id')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropForeign(['store_category_id']);
                    $t->dropColumn('store_category_id');
                });
            }
        }

        Schema::dropIfExists('store_categories');
    }

    public function down(): void
    {
        Schema::create('store_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('type', 20)->default('product');
            $table->timestamps();
        });
    }
};