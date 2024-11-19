<?php

namespace HermesDj\Seat\Industry\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('seat_alliance_industry_orders', 'seat_industry_orders');
        Schema::rename('seat_alliance_industry_orders_statistics', 'seat_industry_orders_statistics');
        Schema::rename('seat_alliance_industry_order_items', 'seat_industry_order_items');
        Schema::rename('seat_alliance_industry_deliveries', 'seat_industry_deliveries');
        Schema::rename('seat_alliance_industry_delivery_items', 'seat_industry_delivery_items');
        Schema::rename('seat_alliance_industry_deliveries_statistics', 'seat_industry_deliveries_statistics');
    }

    public function down(): void
    {
        Schema::rename('seat_industry_orders', 'seat_alliance_industry_orders');
        Schema::rename('seat_industry_orders_statistics', 'seat_alliance_industry_orders_statistics');
        Schema::rename('seat_industry_order_items', 'seat_alliance_industry_order_items');
        Schema::rename('seat_industry_deliveries', 'seat_alliance_industry_deliveries');
        Schema::rename('seat_industry_delivery_items', 'seat_alliance_industry_delivery_items');
        Schema::rename('seat_industry_deliveries_statistics', 'seat_alliance_industry_deliveries_statistics');
    }
};