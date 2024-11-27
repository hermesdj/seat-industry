<?php

use Illuminate\Database\Migrations\Migration;
use RecursiveTree\Seat\TreeLib\Helpers\ScheduleHelper;

return new class extends Migration {
    public function up(): void
    {
        ScheduleHelper::scheduleCommand('seat-industry:notifications', '0 * * * *');
    }

    public function down(): void
    {
        ScheduleHelper::removeCommand('seat-industry:notifications');
    }
};
