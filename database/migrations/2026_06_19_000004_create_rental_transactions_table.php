<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_item_id')->constrained('rental_items')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('conversation_id')->nullable()->constrained()->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('deposit_amount', 15, 2)->default(0);
            $table->string('status')->default('pending');
            // pending, awaiting_payment, confirmed, active, returned, overdue, cancelled, disputed
            $table->string('payment_status')->default('pending'); // pending, paid, refunded
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_transactions');
    }
};
