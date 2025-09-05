<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('magazines', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug')->unique();
            $table->string('cover_path')->nullable();
            $table->string('cover_thumb_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->date('published_at')->nullable();
            $table->string('status', 20)->default('draft'); // draft|published
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magazines');
    }
};
