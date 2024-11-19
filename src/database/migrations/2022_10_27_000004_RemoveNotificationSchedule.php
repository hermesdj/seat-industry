
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Seat\Services\Models\Schedule;

class RemoveNotificationSchedule extends Migration
{
    public function up()
    {
        $id =  \HermesDj\Seat\Industry\IndustrySettings::$NOTIFICATION_COMMAND_SCHEDULE_ID->get();
        if($id){
            Schedule::destroy($id);
            \HermesDj\Seat\Industry\IndustrySettings::$NOTIFICATION_COMMAND_SCHEDULE_ID->set(null);
        }
    }

    public function down()
    {
        $id = \HermesDj\Seat\TreeLib\Helpers\ScheduleHelper::scheduleCommand("Industry:notifications","0 * * * *");

        \HermesDj\Seat\Industry\IndustrySettings::$NOTIFICATION_COMMAND_SCHEDULE_ID->set($id);
    }
}

