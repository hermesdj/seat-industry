<?php

namespace Seat\HermesDj\Industry\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seat_industry_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->bigInteger('user_id');
            $table->bigInteger('price');
            $table->bigInteger('location_id');
            $table->dateTime('created_at', 0);
            $table->dateTime('produce_until', 0);
            $table->boolean('completed')->default(false);
            $table->dateTime('completed_at')->nullable();
            $table->boolean('add_seat_inventory')->default(false);
            $table->float('profit');
            $table->integer('priority')->unsigned();
            $table->bigInteger('priceProvider')->unsigned()->nullable();
            $table->boolean('is_repeating')->default(false);
            $table->dateTime('repeat_date')->nullable();
            $table->smallInteger('repeat_interval')->unsigned()->nullable();
            $table->string('order_id', 6);
            $table->string('reference', 32);
            $table->bigInteger('corp_id')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->bigInteger('deliver_to')->nullable();
        });

        Schema::create('seat_industry_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->index();
            $table->bigInteger('type_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->bigInteger('unit_price')->default(0);
        });

        Schema::create('seat_industry_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('delivery_code', 6);
            $table->bigInteger('order_id');
            $table->bigInteger('user_id');
            $table->integer('quantity');
            $table->boolean('completed')->default(false);
            $table->dateTime('accepted');
            $table->dateTime('completed_at')->nullable();
            $table->bigInteger('seat_inventory_source')->nullable();
        });

        Schema::create('seat_industry_delivery_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('order_item_id');
            $table->bigInteger('delivery_id');
            $table->integer('quantity_delivered')->default(0);
            $table->boolean('completed')->default(false);
            $table->dateTime('accepted');
            $table->dateTime('completed_at')->nullable();
        });

        Schema::create('seat_industry_orders_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->dateTime('created_at');
            $table->dateTime('completed_at')->nullable();
        });

        Schema::create('seat_industry_deliveries_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('delivery_id');
            $table->bigInteger('user_id');
            $table->dateTime('accepted');
            $table->dateTime('completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_industry_orders');
        Schema::dropIfExists('seat_industry_deliveries');
        Schema::dropIfExists('seat_alliance_industry_order_items');
        Schema::dropIfExists('seat_alliance_industry_delivery_items');
        Schema::dropIfExists('seat_alliance_industry_orders_statistics');
        Schema::dropIfExists('seat_alliance_industry_deliveries_statistics');
    }
};
