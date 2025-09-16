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
        Schema::table('categories', function (Blueprint $table) {
            // Ajouter les colonnes manquantes si elles n'existent pas
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug', 150)->unique()->after('name');
            }
            if (!Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('description');
            }
            if (!Schema::hasColumn('categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('parent_id');
            }
            if (!Schema::hasColumn('categories', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('sort_order');
            }
            if (!Schema::hasColumn('categories', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('status');
            }
        });
        
        // Ajouter les contraintes de clés étrangères après avoir ajouté les colonnes
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'parent_id') && !$this->hasForeignKey($table, 'categories_parent_id_foreign')) {
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            }
            if (Schema::hasColumn('categories', 'user_id') && !$this->hasForeignKey($table, 'categories_user_id_foreign')) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    private function hasForeignKey(Blueprint $table, string $name): bool
    {
        $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys($table->getTable());
        foreach ($foreignKeys as $foreignKey) {
            if (strtolower($foreignKey->getName()) === strtolower($name)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Supprimer les contraintes de clés étrangères d'abord
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['user_id']);
            
            // Supprimer les colonnes ajoutées
            $table->dropColumn(['slug', 'description', 'parent_id', 'sort_order', 'status', 'user_id']);
        });
    }
};
