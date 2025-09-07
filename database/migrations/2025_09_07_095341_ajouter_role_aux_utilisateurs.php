<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter les champs de gestion des rôles aux utilisateurs
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajout du champ role avec valeur par défaut 'journaliste'
            $table->enum('role_utilisateur', ['admin', 'directeur_publication', 'journaliste'])
                  ->default('journaliste')
                  ->after('email')
                  ->comment('Rôle de l\'utilisateur dans le système de publication');
            
            // Ajout du champ actif pour pouvoir désactiver un utilisateur
            $table->boolean('est_actif')
                  ->default(true)
                  ->after('role_utilisateur')
                  ->comment('Statut actif de l\'utilisateur');
            
            // Ajout de la date de dernière connexion pour le suivi
            $table->timestamp('derniere_connexion')
                  ->nullable()
                  ->after('est_actif')
                  ->comment('Date et heure de la dernière connexion');
        });
    }

    /**
     * Supprimer les champs ajoutés
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role_utilisateur', 'est_actif', 'derniere_connexion']);
        });
    }
};
