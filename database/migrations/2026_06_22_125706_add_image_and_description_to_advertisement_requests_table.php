<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisement_requests', function (Blueprint $table) {
            $table->string('image')->nullable()->after('title');
            $table->text('description')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('advertisement_requests', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('description');
        });
    }
};
