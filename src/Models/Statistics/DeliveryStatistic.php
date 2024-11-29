<?php

namespace Seat\HermesDj\Industry\Models\Statistics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Seat\Web\Models\User;

class DeliveryStatistic extends Model
{
    public $timestamps = false;

    protected $table = 'seat_industry_deliveries_statistics';

    protected $fillable = ['order_id', 'delivery_id', 'user_id', 'accepted', 'completed_at'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function meanUserDeliveryTime()
    {
        return self::select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF(completed_at, accepted))) AS timediff'), 'user_id')
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->get();
    }

    public static function meanDeliveryCompletionTime()
    {
        $result = self::select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF(completed_at, accepted))) AS timediff'))
            ->whereNotNull('completed_at')
            ->get();

        return $result[0]->timediff;
    }

    public static function totalCompletedDeliveryCount(): int
    {
        return self::whereNotNull('completed_at')
            ->count();
    }

    public static function queryDeliveryCompletedByUser(): Builder
    {
        return self::whereNotNull('completed_at')
            ->selectRaw('count(id) as value, user_id')
            ->groupBy('user_id')
            ->orderBy('value', 'desc');
    }

    public static function queryDeliveryMeanCompletionTimeByUser(): Builder
    {
        return self::select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF(completed_at, accepted))) AS value, user_id'))
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->orderBy('value', 'asc');
    }

    public static function queryFastestCompletionTimeByUser(): Builder
    {
        return self::select(DB::raw('MIN(TIME_TO_SEC(TIMEDIFF(completed_at, accepted))) AS value, user_id'))
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->orderBy('value', 'asc');
    }
}
