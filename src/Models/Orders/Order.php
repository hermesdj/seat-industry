<?php

namespace Seat\HermesDj\Industry\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\HermesDj\Industry\Helpers\EveHelper;
use Seat\HermesDj\Industry\Models\Deliveries\Delivery;
use Seat\HermesDj\Industry\Models\Deliveries\DeliveryItem;
use Seat\Web\Models\User;

class Order extends Model
{
    public $timestamps = false;

    protected $table = 'seat_industry_orders';

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'order_id', 'id');
    }

    public function deliveryItems(): HasMany
    {
        return $this->hasMany(DeliveryItem::class, 'order_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function allowedItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id')->where('rejected', false);
    }

    public function rejectedItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id')->where('rejected', true);
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
        return $this->deliveryItems->sum('quantity_delivered');
    }

    public function totalQuantity(): int
    {
        return $this->items->sum('quantity');
    }

    public function hasPendingDeliveries(): bool
    {
        return $this->deliveries()->where('completed', false)->exists();
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
            }, 0.0);
    }

    public function totalDelivered(): float
    {
        return $this->deliveryItems()
            ->where('completed', true)
            ->get()
            ->reduce(function ($total, $item) {
                return $total + ($item->orderItem->unit_price * $item->quantity_delivered / 100);
            }, 0.0);
    }

    public function totalRejected(): float
    {
        return $this->rejectedItems()->sum(DB::raw('unit_price * quantity / 100'));
    }

    public function isCorpAllowed(User $user): bool
    {
        return $user->characters()->get()->some(function (CharacterInfo $character) {
            return $character->affiliation->corporation_id == $this->corp_id;
        });
    }

    public static function availableOrders(): Collection
    {
        return Order::with('deliveries')
            ->where('confirmed', true)
            ->where('completed', false)
            ->where('produce_until', '>', DB::raw('NOW()'))
            ->where('is_repeating', false)
            ->whereNull('corp_id')
            ->get()
            ->filter(function ($order) {
                return $order->assignedQuantity() < $order->totalQuantity();
            });
    }

    public static function expiredOrders(): Collection
    {
        return Order::with('deliveries')
            ->where('confirmed', true)
            ->where('completed', false)
            ->where('produce_until', '<', DB::raw('NOW()'))
            ->where('is_repeating', false)
            ->whereNull('corp_id')
            ->get();
    }

    public static function corporationsOrders(): Collection
    {
        $corpIds = auth()->user()->characters->map(function ($char) {
            return $char->affiliation->corporation_id;
        });

        return Order::with('deliveries')
            ->where('confirmed', true)
            ->where('completed', false)
            ->where('is_repeating', false)
            ->whereIn('corp_id', $corpIds)
            ->get();
    }

    public static function connectedUserOrders(): Collection
    {
        return Order::where('user_id', auth()->user()->id)->get();
    }

    public static function countAvailableOrders(): int
    {
        return self::availableOrders()->count();
    }

    public static function countCorporationOrders(): int
    {
        return self::corporationsOrders()->count();
    }

    public static function countExpiredOrders(): int
    {
        return self::expiredOrders()->count();
    }

    public static function countPersonalOrders(): int
    {
        return self::connectedUserOrders()->count();
    }

    public function hasRejectedItemsNotDelivered(): bool
    {
        return $this->rejectedItems()->get()->filter(function ($item) {
                return $item->quantity - $item->assignedQuantity() > 0;
            })->count() > 0;
    }

    public function formatRejectedToBuyAll(): string
    {
        return EveHelper::formatOrderItemsToBuyAll($this->rejectedItems()->get()->filter(function ($item) {
            return $item->quantity - $item->assignedQuantity() > 0;
        }));
    }
}
