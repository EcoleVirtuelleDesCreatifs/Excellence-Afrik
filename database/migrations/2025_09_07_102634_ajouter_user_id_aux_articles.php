<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter le champ user_id pour lier les articles aux auteurs
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Ajouter la colonne user_id avec clé étrangère vers users
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Auteur de l\'article');
        });
    }

    /**
     * Supprimer le champ user_id
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
