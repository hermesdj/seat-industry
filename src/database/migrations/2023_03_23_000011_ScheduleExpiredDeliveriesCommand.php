<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleExpiredDeliveriesCommand extends Migration
{
    public function up()
    {
        \HermesDj\Seat\TreeLib\Helpers\ScheduleHelper::scheduleCommand("Industry:deliveries:expired","20 20 * * *");
    }

    public function down()
    {

    }
}

