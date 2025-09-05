<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webtvs', function (Blueprint $table) {
            $table->id();
            $table->string('type_programme'); // live | programme
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('duree_estimee')->nullable(); // minutes
            $table->string('statut')->default('draft'); // draft|programme|en_direct|termine
            $table->boolean('est_actif')->default(false);
            $table->timestamp('date_programmee')->nullable();
            // Programme fields
            $table->string('categorie')->nullable();
            $table->text('code_integration_vimeo')->nullable();
            $table->string('video_id')->nullable();
            // Live fields
            $table->text('code_embed_vimeo')->nullable();
            $table->string('vimeo_event_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webtvs');
    }
};
