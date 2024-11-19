<?php

namespace HermesDj\Seat\Industry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use HermesDj\Seat\PricesCore\Models\PriceProviderInstance;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\Web\Models\User;


class Order extends Model
{
    public $timestamps = false;

    protected $table = 'seat_alliance_industry_orders';

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, "order_id", "id");
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class, "order_id", "id");
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, "order_id", "id");
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function deliverToCharacter()
    {
        return $this->hasOne(CharacterInfo::class, 'character_id', 'deliver_to');
    }

    public function station()
    {
        return $this->hasOne(UniverseStation::class, 'station_id', 'location_id');
    }

    public function structure()
    {
        return $this->hasOne(UniverseStructure::class, 'structure_id', 'location_id');
    }

    public function corporation()
    {
        return $this->hasOne(CorporationInfo::class, 'corporation_id', 'corp_id');
    }

    public function location()
    {
        return $this->station ?: $this->structure;
    }

    public function priceProviderInstance()
    {
        return $this->hasOne(PriceProviderInstance::class, 'id', 'priceProvider');
    }

    public function assignedQuantity()
    {
        return $this->deliveryItems->sum("quantity_delivered");
    }

    public function totalQuantity()
    {
        return $this->items->sum("quantity");
    }

    public function hasPendingDeliveries()
    {
        return $this->deliveries()->where("completed", false)->exists();
    }

    public function totalValue()
    {
        return $this->items()->sum(DB::raw('unit_price * quantity / 100'));
    }

    public function totalInDelivery()
    {
        return $this->deliveryItems()
            ->where('completed', false)
            ->get()
            ->reduce(function ($total, $item) {
                return $total + ($item->orderItem->unit_price * $item->quantity_delivered / 100);
            });
    }

    public function totalDelivered()
    {
        return $this->deliveryItems()
            ->where('completed', true)
            ->get()
            ->reduce(function ($total, $item) {
                return $total + ($item->orderItem->unit_price * $item->quantity_delivered / 100);
            });
    }
}