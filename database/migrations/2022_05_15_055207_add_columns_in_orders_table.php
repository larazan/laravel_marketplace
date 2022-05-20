<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('product_id')->after('status');
			$table->integer('customer_id')->after('product_id');
			$table->integer('shop_id')->after('customer_id');
			$table->integer('opened')->after('shop_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('shop_id');
            $table->dropColumn('opened');
        });
    }
}
