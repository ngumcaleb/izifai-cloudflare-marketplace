<?php

use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing role values: 'admin' → 'Superadmin', everything else → 'User'
        DB::statement("UPDATE users SET role = 'Superadmin' WHERE role = 'admin'");
        DB::statement("UPDATE users SET role = 'User' WHERE role IN ('buyer', 'seller', 'user')");

        // Change column to enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Superadmin', 'User') NOT NULL DEFAULT 'User'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NOT NULL DEFAULT 'user'");
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'Superadmin'");
        DB::statement("UPDATE users SET role = 'buyer' WHERE role = 'User'");
    }
};
