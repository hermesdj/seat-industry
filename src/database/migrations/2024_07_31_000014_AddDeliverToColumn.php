<?php

namespace HermesDj\Seat\Industry\database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('seat_alliance_industry_orders', 'deliver_to')) {
            Schema::table('seat_alliance_industry_orders', function (Blueprint $table) {
                $table->bigInteger('deliver_to')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('seat_alliance_industry_orders', 'deliver_to')) {
            Schema::table('seat_alliance_industry_orders', function (Blueprint $table) {
                $table->dropColumn('deliver_to');
            });
        }
    }
};