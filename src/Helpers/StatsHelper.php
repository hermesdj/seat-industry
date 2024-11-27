<?php

namespace Seat\HermesDj\Industry\Helpers;

use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class StatsHelper
{
    public static function displayTimeValueAsHumanReadable(Collection $collection): Collection
    {
        return $collection->map(function ($row) {
            $row->text = CarbonInterval::seconds((int) $row->value)->cascade()->forHumans(['parts' => 2, 'short' => true]);

            return $row;
        });
    }
}
