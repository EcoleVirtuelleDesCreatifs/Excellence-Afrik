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
            $table->text('url');
            $table->string('page_type')->default('home'); // home, category, article, magazines, webtv
            $table->string('category_slug')->nullable(); // slug de la catégorie si page_type = category
            $table->string('position_in_page'); // top_banner, sidebar, middle, bottom
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('click_count')->default(0);
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('priority')->default(1); // Plus le nombre est élevé, plus la priorité est haute
            $table->timestamps();

            $table->index(['status', 'page_type', 'category_slug', 'position_in_page'], 'ads_main_index');
            $table->index(['start_date', 'end_date'], 'ads_date_index');
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
