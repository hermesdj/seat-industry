<?php

namespace HermesDj\Seat\Industry\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('seat_alliance_industry_orders', function (Blueprint $table) {
            $table->string('order_id', 6);
            $table->string('reference', 32);
            $table->bigInteger('corp_id')->nullable();
            $table->boolean('confirmed')->default(false);
        });
        Schema::table('seat_alliance_industry_order_items', function (Blueprint $table) {
            $table->bigInteger('unit_price')->default(0);
        });
        Schema::table('seat_alliance_industry_deliveries', function (Blueprint $table) {
            $table->string('delivery_code', 6);
        });

        DB::statement('UPDATE seat_alliance_industry_orders SET price = price * 100');

        Schema::create('seat_alliance_industry_delivery_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('order_item_id');
            $table->bigInteger('delivery_id');
            $table->integer('quantity_delivered')->default(0);
            $table->boolean('completed')->default(false);
            $table->dateTime('accepted');
            $table->dateTime('completed_at')->nullable();
        });

        Schema::create('seat_alliance_industry_orders_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->dateTime('created_at');
            $table->dateTime('completed_at')->nullable();
        });

        Schema::create('seat_alliance_industry_deliveries_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('delivery_id');
            $table->bigInteger('user_id');
            $table->dateTime('accepted');
            $table->dateTime('completed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('seat_alliance_industry_orders', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('reference');
        });
        Schema::table('seat_alliance_industry_order_items', function (Blueprint $table) {
            $table->dropColumn('unit_price');
            $table->dropColumn('delivery_id');
            $table->dropColumn('delivered_quantity');
        });
        DB::statement('UPDATE seat_alliance_industry_orders SET price = price / 100');

        Schema::dropIfExists('seat_alliance_industry_delivery_items');
        Schema::dropIfExists('seat_alliance_industry_orders_statistics');
        Schema::dropIfExists('seat_alliance_industry_deliveries_statistics');
    }
};