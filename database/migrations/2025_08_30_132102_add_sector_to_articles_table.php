<?php

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
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'sector')) {
                $table->string('sector', 100)->nullable()->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'sector')) {
                // Drop index then column
                try {
                    $table->dropIndex('articles_sector_index');
                } catch (\Throwable $e) {
                    // Fallback: drop index by columns array if needed
                    try { $table->dropIndex(['sector']); } catch (\Throwable $e2) { /* ignore */ }
                }
                $table->dropColumn('sector');
            }
        });
    }
};
