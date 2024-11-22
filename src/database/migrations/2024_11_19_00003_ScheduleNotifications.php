<?php

use Illuminate\Database\Migrations\Migration;
use RecursiveTree\Seat\TreeLib\Helpers\ScheduleHelper;

return new class extends Migration
{
    public function up(): void
    {
        ScheduleHelper::scheduleCommand('seat-industry:notifications', '0 * * * *');
        ScheduleHelper::scheduleCommand('seat-industry:orders:repeating', '21 21 * * *');
        ScheduleHelper::scheduleCommand('seat-industry:deliveries:expired', '20 20 * * *');
    }

    public function down(): void
    {
        ScheduleHelper::removeCommand('seat-industry:notifications');
        ScheduleHelper::removeCommand('seat-industry:orders:repeating');
        ScheduleHelper::removeCommand('seat-industry:deliveries:expired');
    }
};
