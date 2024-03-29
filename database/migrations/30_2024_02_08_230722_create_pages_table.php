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
        Schema::create('pages', function (Blueprint $table) {
            $table->id('page_id');
            $table->string('page_title');
            $table->string('page_image')->default('/front/assets/img/about-bg.jpg');
            $table->longText('page_content');
            $table->string('page_slug');
            $table->unsignedInteger('page_order')->unique();
            $table->unsignedInteger('page_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
