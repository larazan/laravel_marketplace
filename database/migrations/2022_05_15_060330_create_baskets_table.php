<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('name');
            $table->integer('prod_id');
            $table->decimal('price', 15, 2);
            $table->integer('quantity');
            $table->integer('shop_id');
            $table->integer('customer_id');
            $table->integer('ip_address');
            $table->json('attributes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baskets');
    }
}
