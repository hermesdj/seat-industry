<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixMonthlyOrder extends Migration
{
    public function up()
    {
        \HermesDj\Seat\TreeLib\Helpers\ScheduleHelper::removeCommand("Industry:orders:repeating");
        \HermesDj\Seat\TreeLib\Helpers\ScheduleHelper::scheduleCommand("Industry:orders:repeating","21 21 * * *");
    }

    public function down()
    {

    }
}

