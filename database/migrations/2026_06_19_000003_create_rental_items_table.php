<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('subcategory_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('rate', 15, 2);
            $table->string('billing_unit'); // hourly, daily, weekly, monthly
            $table->decimal('deposit', 15, 2)->nullable();
            $table->json('images')->nullable();
            $table->json('availability_calendar')->nullable();
            $table->text('return_conditions')->nullable();
            $table->text('duration_rules')->nullable();
            $table->text('condition_notes')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('location');
            $table->string('status')->default('published'); // draft, published, archived
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_items');
    }
};
