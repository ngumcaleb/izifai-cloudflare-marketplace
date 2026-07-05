<?php

use App\Models\Conversation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('messages', 'metadata')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->json('metadata')->nullable()->after('image');
            });
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique(['buyer_id', 'seller_id', 'target_type', 'target_id']);
        });

        $duplicates = Conversation::selectRaw('buyer_id, seller_id, MAX(id) as keep_id')
            ->groupBy('buyer_id', 'seller_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            $toDelete = Conversation::where('buyer_id', $dup->buyer_id)
                ->where('seller_id', $dup->seller_id)
                ->where('id', '!=', $dup->keep_id)
                ->pluck('id');

            \App\Models\Message::whereIn('conversation_id', $toDelete)
                ->update(['conversation_id' => $dup->keep_id]);

            Conversation::whereIn('id', $toDelete)->delete();
        }

        Schema::table('conversations', function (Blueprint $table) {
            $table->unique(['buyer_id', 'seller_id']);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        if (Schema::hasColumn('messages', 'metadata')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('metadata');
            });
        }

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique(['buyer_id', 'seller_id']);
            $table->unique(['buyer_id', 'seller_id', 'target_type', 'target_id']);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
