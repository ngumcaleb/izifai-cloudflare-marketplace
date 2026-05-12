<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('advertisement_requests', function (Blueprint $table) {
            $table->string('payment_sender_number')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisement_requests', function (Blueprint $table) {
            $table->dropColumn(['payment_sender_number', 'total_amount']);
        });
    }
};
