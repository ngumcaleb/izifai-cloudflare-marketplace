<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->morphs('target');
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->integer('buyer_unread')->default(0);
            $table->integer('seller_unread')->default(0);
            $table->timestamps();

            $table->unique(['buyer_id', 'seller_id', 'target_type', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
