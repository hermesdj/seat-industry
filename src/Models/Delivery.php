<?php

namespace HermesDj\Seat\Industry\Models;

use Illuminate\Database\Eloquent\Model;
use HermesDj\Seat\TreeLib\Helpers\SeatInventoryPluginHelper;
use Seat\Web\Models\User;

class Delivery extends Model
{
    public $timestamps = false;

    protected $table = 'seat_alliance_industry_deliveries';

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function seatInventorySource()
    {
        return $this->hasOne(SeatInventoryPluginHelper::$INVENTORY_SOURCE_MODEL, 'id', 'seat_inventory_source');
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class, "delivery_id", "id");
    }

    public function totalQuantity()
    {
        return $this->deliveryItems->sum('quantity_delivered');
    }

    public function totalPrice()
    {
        return $this->deliveryItems->reduce(function (?int $carry, DeliveryItem $item) {
            return $carry + $item->orderItem->unit_price * $item->quantity_delivered;
        });
    }
}