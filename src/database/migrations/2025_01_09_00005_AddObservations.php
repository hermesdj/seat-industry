<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seat_industry_orders', function (Blueprint $table) {
            if (! Schema::hasColumn('seat_industry_orders', 'observations')) {
                $table->string('observations', 255)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('seat_industry_orders', function (Blueprint $table) {
            if (Schema::hasColumn('seat_industry_orders', 'observations')) {
                $table->removeColumn('observations');
            }
        });
    }
};
