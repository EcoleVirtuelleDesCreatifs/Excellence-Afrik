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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('url', 500);
            $table->string('page_type');
            $table->string('category_slug')->nullable();
            $table->string('position_in_page');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('click_count')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedTinyInteger('priority')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
