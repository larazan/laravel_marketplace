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
            $table->integer('customer_id')->after('status');
			$table->integer('shop_id')->after('customer_id');
			$table->integer('opened')->after('shop_id')->default(0);
            $table->integer('opened_cus')->after('opened')->default(0);
            $table->integer('opened_shopper')->after('opened_cus')->default(0);
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
            $table->dropColumn('customer_id');
            $table->dropColumn('shop_id');
            $table->dropColumn('opened');
            $table->dropColumn('opened_cus');
            $table->dropColumn('opened_shopper');
        });
    }
}
