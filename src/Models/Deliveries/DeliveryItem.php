<?php

namespace Seat\HermesDj\Industry\Models\Deliveries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\HermesDj\Industry\Models\Orders\OrderItem;

class DeliveryItem extends Model
{
    public $timestamps = false;

    protected $table = 'seat_industry_delivery_items';

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function orderItem(): HasOne
    {
        return $this->hasOne(OrderItem::class, 'id', 'order_item_id');
    }
}
