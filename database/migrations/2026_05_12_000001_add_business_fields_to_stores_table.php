<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('business_email')->nullable()->after('whatsapp_number');
            $table->text('open_hours')->nullable()->after('business_email');
            $table->json('social_links')->nullable()->after('open_hours');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['business_email', 'open_hours', 'social_links']);
        });
    }
};
