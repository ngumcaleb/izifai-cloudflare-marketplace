<?php
/* 2026_05_09_090604_add_status_to_users_and_stores_table.php */
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->after('role'); // active, suspended
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->string('status')->default('active')->after('is_verified'); // active, suspended
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
