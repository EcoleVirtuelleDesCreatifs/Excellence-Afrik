<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'theme')) {
                $table->string('theme', 50)->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'theme')) {
                try { $table->dropIndex('articles_theme_index'); } catch (\Throwable $e) { try { $table->dropIndex(['theme']); } catch (\Throwable $e2) { /* ignore */ } }
                $table->dropColumn('theme');
            }
        });
    }
};
