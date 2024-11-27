<?php

use Illuminate\Database\Migrations\Migration;
use RecursiveTree\Seat\TreeLib\Helpers\ScheduleHelper;

return new class extends Migration
{
    public function up(): void
    {
        ScheduleHelper::scheduleCommand('seat-industry:assets:user:names', '*/30 * * * *');
        ScheduleHelper::scheduleCommand('seat-industry:assets:corp:names', '*/30 * * * *');
    }

    public function down(): void
    {
        ScheduleHelper::removeCommand('seat-industry:assets:user:names');
        ScheduleHelper::removeCommand('seat-industry:assets:corp:names');
    }
};
