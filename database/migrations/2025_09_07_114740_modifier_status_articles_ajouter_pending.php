<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Modifier la colonne status pour ajouter 'pending'
     */
    public function up(): void
    {
        // Pour modifier un ENUM en MySQL, on doit utiliser du SQL brut
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft','pending','published','scheduled','archived') NOT NULL DEFAULT 'draft' COMMENT 'Statut de l''article avec validation journaliste'");
    }

    /**
     * Reverse the migrations.
     * Revenir à l'ancien ENUM sans 'pending'
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft','published','scheduled','archived') NOT NULL DEFAULT 'draft'");
    }
};
