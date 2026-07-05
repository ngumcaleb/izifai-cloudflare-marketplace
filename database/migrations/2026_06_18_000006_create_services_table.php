<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('starting_price', 15, 2);
            $table->string('delivery_time')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->string('status')->default('active');
            $table->unsignedBigInteger('views')->default(0);
            $table->string('approval_status')->default('approved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
