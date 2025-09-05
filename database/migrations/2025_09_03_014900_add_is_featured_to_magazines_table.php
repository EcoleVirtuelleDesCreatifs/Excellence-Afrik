<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('magazines')) return;
        Schema::table('magazines', function (Blueprint $table) {
            if (!Schema::hasColumn('magazines', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('magazines')) return;
        Schema::table('magazines', function (Blueprint $table) {
            if (Schema::hasColumn('magazines', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
        });
    }
};
