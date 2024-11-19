<?php

namespace HermesDj\Seat\Industry\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    public $timestamps = false;
    protected $table = 'seat_alliance_industry_delivery_items';

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class, 'id', 'order_item_id');
    }
}