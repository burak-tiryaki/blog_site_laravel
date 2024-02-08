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
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->unsignedBigInteger('category_id');//ilişki kurulacak tabloların unsigned olması gerekir. eksi değer almaması için.
            $table->string('article_title');
            $table->text('article_content');
            $table->string('article_slug');
            $table->integer('article_hit')->default(0);
            $table->string('article_image');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories');
                //->onDelete('cascade');//Eğer bir category silinirse, o category'e sahip yazılar da silinir.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};