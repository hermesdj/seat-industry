<?php

namespace Seat\HermesDj\Industry\Models\Statistics;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderStatistic extends Model
{
    public $timestamps = false;

    protected $table = 'seat_industry_orders_statistics';

    protected $fillable = ['order_id', 'created_at', 'completed_at'];

    public static function generateAll(): object
    {
        return (object)[
            'completed' => self::totalCompletedOrderCount(),
            'completedByMonth' => self::totalOrderCompletedByMonth(),
            'meanCompletionTime' => self::meanOrderCompletionTime(),
            'completedDeliveries' => DeliveryStatistic::totalCompletedDeliveryCount(),
            'meanDeliveryCompletionTime' => DeliveryStatistic::meanDeliveryCompletionTime(),
            'userPerformances' => self::userPerformances()
        ];
    }

    public static function totalCompletedOrderCount(): int
    {
        return self::whereNotNull('completed_at')
            ->count();
    }

    public static function totalOrderCompletedByMonth(): Collection
    {
        return self::select(DB::raw('count(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') month"))
            ->whereNotNull('completed_at')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public static function meanOrderCompletionTime()
    {
        $result = self::select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF(completed_at, created_at))) AS timediff'))
            ->whereNotNull('completed_at')
            ->get();

        return $result[0]->timediff;
    }

    public static function userPerformances(): object
    {
        return (object)[
            'deliveryTime' => DeliveryStatistic::meanUserDeliveryTime()
        ];
    }
}