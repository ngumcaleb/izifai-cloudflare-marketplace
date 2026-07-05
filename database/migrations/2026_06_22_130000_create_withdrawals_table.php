<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2)->default(0);
            $table->string('method'); // mtn_momo, orange_money, bank
            $table->string('account_number');
            $table->string('account_name')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, completed
            $table->text('admin_note')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        // Seed default platform settings
        $exists = DB::table('settings')->where('key', 'platform_fee_percentage')->exists();
        if (!$exists) {
            DB::table('settings')->insert([
                ['key' => 'platform_fee_percentage', 'value' => '5'],
                ['key' => 'platform_name', 'value' => 'IZIFAI'],
                ['key' => 'platform_currency', 'value' => 'XAF'],
                ['key' => 'min_withdrawal', 'value' => '1000'],
                ['key' => 'platform_support_email', 'value' => 'support@izifai.com'],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
