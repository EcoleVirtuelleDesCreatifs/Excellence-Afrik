<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flash_infos', function (Blueprint $table) {
            if (Schema::hasColumn('flash_infos', 'contenu')) {
                $table->dropColumn('contenu');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flash_infos', function (Blueprint $table) {
            $table->text('contenu')->after('titre');
        });
    }
};
