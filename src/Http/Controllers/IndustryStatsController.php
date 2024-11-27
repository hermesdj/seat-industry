<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\View;
use Seat\HermesDj\Industry\Models\Statistics\DeliveryStatistic;
use Seat\Web\Http\Controllers\Controller;

class IndustryStatsController extends Controller
{
    public function scoreboard(): View
    {
        $producersCountQuery = DeliveryStatistic::queryDeliveryCompletedByUser();
        $producersMeanTimeQuery = DeliveryStatistic::queryDeliveryMeanCompletionTimeByUser();
        $fastestProducerQuery = DeliveryStatistic::queryFastestCompletionTimeByUser();

        return view(
            'seat-industry::statistics.scoreboard',
            compact('producersCountQuery', 'producersMeanTimeQuery', 'fastestProducerQuery')
        );
    }
}