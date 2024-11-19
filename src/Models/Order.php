<?php

namespace HermesDj\Seat\Industry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, "order_id", "id");
    }

    public function deliveryItems(): HasMany
    {
        return $this->hasMany(DeliveryItem::class, "order_id", "id");
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, "order_id", "id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function deliverToCharacter(): HasOne
    {
        return $this->hasOne(CharacterInfo::class, 'character_id', 'deliver_to');
    }

    public function station(): HasOne
    {
        return $this->hasOne(UniverseStation::class, 'station_id', 'location_id');
    }

    public function structure(): HasOne
    {
        return $this->hasOne(UniverseStructure::class, 'structure_id', 'location_id');
    }

    public function corporation(): HasOne
    {
        return $this->hasOne(CorporationInfo::class, 'corporation_id', 'corp_id');
    }

    public function location()
    {
        return $this->station ?: $this->structure;
    }

    public function priceProviderInstance(): HasOne
    {
        return $this->hasOne(PriceProviderInstance::class, 'id', 'priceProvider');
    }

    public function assignedQuantity(): int
    {
        return $this->deliveryItems->sum("quantity_delivered");
    }

    public function totalQuantity(): int
    {
        return $this->items->sum("quantity");
    }

    public function hasPendingDeliveries(): bool
    {
        return $this->deliveries()->where("completed", false)->exists();
    }

    public function totalValue(): float
    {
        return $this->items()->sum(DB::raw('unit_price * quantity / 100'));
    }

    public function totalInDelivery(): float
    {
        return $this->deliveryItems()
            ->where('completed', false)
            ->get()
            ->reduce(function ($total, $item) {
                return $total + ($item->orderItem->unit_price * $item->quantity_delivered / 100);
            });
    }

    public function totalDelivered(): float
    {
        return $this->deliveryItems()
            ->where('completed', true)
            ->get()
            ->reduce(function ($total, $item) {
                return $total + ($item->orderItem->unit_price * $item->quantity_delivered / 100);
            });
    }
}