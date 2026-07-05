<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('name');
            $table->string('sku')->nullable()->after('slug');
            $table->integer('inventory')->default(0)->after('stock_status');
            $table->string('video_url')->nullable()->after('description');
            $table->string('approval_status')->default('approved')->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brand', 'sku', 'inventory', 'video_url', 'approval_status']);
        });
    }
};
