<?php

namespace Seat\HermesDj\Industry\Models\Deliveries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use RecursiveTree\Seat\TreeLib\Helpers\SeatInventoryPluginHelper;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Web\Models\User;

class Delivery extends Model
{
    public $timestamps = false;

    protected $table = 'seat_industry_deliveries';

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function seatInventorySource(): HasOne
    {
        return $this->hasOne(SeatInventoryPluginHelper::$INVENTORY_SOURCE_MODEL, 'id', 'seat_inventory_source');
    }

    public function deliveryItems(): HasMany
    {
        return $this->hasMany(DeliveryItem::class, 'delivery_id', 'id');
    }

    public function totalQuantity(): int
    {
        return $this->deliveryItems->sum('quantity_delivered');
    }

    public function totalPrice(): float
    {
        return $this->deliveryItems->reduce(function (?float $carry, DeliveryItem $item) {
            return $carry + $item->orderItem->unit_price * $item->quantity_delivered;
        }, 0.0);
    }
}
