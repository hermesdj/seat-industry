<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seat_alliance_industry_orders')) {
            DB::statement('INSERT INTO seat_industry_orders SELECT * FROM seat_alliance_industry_orders');
        }

        if (Schema::hasTable('seat_alliance_industry_order_items')) {
            DB::statement('INSERT INTO seat_industry_order_items SELECT id, order_id, type_id, quantity, unit_price, 0 FROM seat_alliance_industry_order_items');
        }

        if (Schema::hasTable('seat_alliance_industry_deliveries')) {
            DB::statement('INSERT INTO seat_industry_deliveries SELECT * FROM seat_alliance_industry_deliveries');
        }

        if (Schema::hasTable('seat_alliance_industry_delivery_items')) {
            DB::statement('INSERT INTO seat_industry_delivery_items SELECT * FROM seat_alliance_industry_delivery_items');
        }

        if (Schema::hasTable('seat_alliance_industry_orders_statistics')) {
            DB::statement('INSERT INTO seat_industry_orders_statistics SELECT * FROM seat_alliance_industry_orders_statistics');
        }

        if (Schema::hasTable('seat_alliance_industry_deliveries_statistics')) {
            DB::statement('INSERT INTO seat_industry_deliveries_statistics SELECT * FROM seat_alliance_industry_deliveries_statistics');
        }
    }

    public function down(): void {}
};
