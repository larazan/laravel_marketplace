<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('article_type');
            $table->datetime('published_at')->nullable();
            $table->integer('status');
            $table->text('body');
            $table->string('author')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->index('slug');
            $table->index('published_at');
            $table->index('article_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
