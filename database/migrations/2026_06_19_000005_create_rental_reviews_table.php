<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_item_id')->constrained('rental_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->json('images')->nullable();
            $table->json('helpful')->nullable();
            $table->timestamps();
            $table->unique(['rental_item_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_reviews');
    }
};
