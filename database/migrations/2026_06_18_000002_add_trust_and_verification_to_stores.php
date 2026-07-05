<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('verification_level')->default('none')->after('is_verified');
            $table->decimal('trust_score', 5, 2)->default(0)->after('verification_level');
            $table->decimal('completion_rate', 5, 2)->default(0)->after('trust_score');
            $table->integer('follower_count')->default(0)->after('completion_rate');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['verification_level', 'trust_score', 'completion_rate', 'follower_count']);
        });
    }
};
