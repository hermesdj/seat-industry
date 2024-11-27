<h4>{{trans('seat-industry::stats.scoreboard.categories.last_year')}}</h4>
<hr/>
<div class="row">
    <div class="col-4">
        @include('seat-industry::statistics.partials.scores.display-score-table',
            [
                'title' => trans('seat-industry::stats.scoreboard.bestProducersByCount'),
                'scoreHeader' => trans('seat-industry::stats.scoreboard.headers.nb_deliveries'),
                'rows' => $producersCountQuery->clone()->whereYear('completed_at', '=', \Carbon\Carbon::now()->year)->get()
            ]
        )
    </div>
    <div class="col-4">
        @include('seat-industry::statistics.partials.scores.display-score-table',
            [
                'title' => trans('seat-industry::stats.scoreboard.bestProducersByTime'),
                'scoreHeader' => trans('seat-industry::stats.scoreboard.headers.timediff'),
                'rows' => \Seat\HermesDj\Industry\Helpers\StatsHelper::displayTimeValueAsHumanReadable($producersMeanTimeQuery->clone()->whereYear('completed_at', '=', \Carbon\Carbon::now()->year)->get())
            ]
        )
    </div>
    <div class="col-4">
        @include('seat-industry::statistics.partials.scores.display-score-table',
            [
                'title' => trans('seat-industry::stats.scoreboard.fastestProducer'),
                'scoreHeader' => trans('seat-industry::stats.scoreboard.headers.fastest_time'),
                'rows' => \Seat\HermesDj\Industry\Helpers\StatsHelper::displayTimeValueAsHumanReadable($fastestProducerQuery->clone()->whereYear('completed_at', '=', \Carbon\Carbon::now()->year)->get())
            ]
        )
    </div>
</div>
