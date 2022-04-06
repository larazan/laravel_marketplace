<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('sku');
            $table->string('type');
            $table->string('name');
            $table->string('slug');
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
