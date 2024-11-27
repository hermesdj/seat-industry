<h4>{{trans('seat-industry::stats.scoreboard.categories.last_month')}}</h4>
<hr/>
<div class="row">
    <div class="col-4">
        @include('seat-industry::statistics.partials.scores.display-score-table',
            [
                'title' => trans('seat-industry::stats.scoreboard.bestProducersByCount'),
                'scoreHeader' => trans('seat-industry::stats.scoreboard.headers.nb_deliveries'),
                'rows' => $producersCountQuery->where('completed_at', '>', \Carbon\Carbon::now()->subDays(30)->endOfDay())->get()
            ]
        )
    </div>
    <div class="col-4">
        @include('seat-industry::statistics.partials.scores.display-score-table',
            [
                'title' => trans('seat-industry::stats.scoreboard.bestProducersByTime'),
                'scoreHeader' => trans('seat-industry::stats.scoreboard.headers.timediff'),
                'rows' => \Seat\HermesDj\Industry\Helpers\StatsHelper::displayTimeValueAsHumanReadable($producersMeanTimeQuery->where('completed_at', '>', \Carbon\Carbon::now()->subDays(30)->endOfDay())->get())
            ]
        )
    </div>
    <div class="col-4">
        @include('seat-industry::statistics.partials.scores.display-score-table',
            [
                'title' => trans('seat-industry::stats.scoreboard.fastestProducer'),
                'scoreHeader' => trans('seat-industry::stats.scoreboard.headers.fastest_time'),
                'rows' => \Seat\HermesDj\Industry\Helpers\StatsHelper::displayTimeValueAsHumanReadable($fastestProducerQuery->where('completed_at', '>', \Carbon\Carbon::now()->subDays(30)->endOfDay())->get())
            ]
        )
    </div>
</div>