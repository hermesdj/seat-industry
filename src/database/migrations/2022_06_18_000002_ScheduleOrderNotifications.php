<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Seat\Services\Models\Schedule;

class ScheduleOrderNotifications extends Migration
{
    public function up()
    {
        $schedule = new Schedule();
        $schedule->command = "Industry:notifications";
        $schedule->expression = "0 * * * *";
        $schedule->allow_overlap = false;
        $schedule->allow_maintenance = false;
        $schedule->save();

        \HermesDj\Seat\Industry\IndustrySettings::$NOTIFICATION_COMMAND_SCHEDULE_ID->set($schedule->id);
    }

    public function down()
    {
        $id =  \HermesDj\Seat\Industry\IndustrySettings::$NOTIFICATION_COMMAND_SCHEDULE_ID->get(null);
        if($id){
            Schedule::destroy($id);
        }
    }
}

