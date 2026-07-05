<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('email_verified')->default(false)->after('email_verified_at');
            $table->boolean('phone_verified')->default(false)->after('phone');
            $table->string('verification_level')->default('none')->after('status');
            $table->decimal('trust_score', 5, 2)->default(0)->after('verification_level');
            $table->string('fcm_token')->nullable()->after('trust_score');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_verified', 'phone_verified', 'verification_level', 'trust_score', 'fcm_token']);
            $table->dropSoftDeletes();
        });
    }
};
