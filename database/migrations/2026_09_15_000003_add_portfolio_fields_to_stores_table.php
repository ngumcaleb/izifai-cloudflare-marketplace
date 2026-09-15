<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedSmallInteger('founded_year')->nullable()->after('about');
            $table->json('policies')->nullable()->after('founded_year');
            $table->json('certifications')->nullable()->after('policies');
            $table->text('map_embed')->nullable()->after('certifications');
        });

        Schema::create('store_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_team_members');

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['founded_year', 'policies', 'certifications', 'map_embed']);
        });
    }
};