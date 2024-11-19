<?php

namespace HermesDj\Seat\Industry\Models;

use Illuminate\Database\Eloquent\Model;
use HermesDj\Seat\Industry\Item\PriceableEveItem;
use HermesDj\Seat\TreeLib\Items\ToEveItem;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Services\Contracts\HasTypeID;

class OrderItem extends Model implements ToEveItem, HasTypeID
{
    public $timestamps = false;

    protected $table = 'seat_alliance_industry_order_items';

    public function type()
    {
        return $this->hasOne(InvType::class, 'typeID', 'type_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class, 'order_item_id', 'id');
    }

    public function toEveItem(): PriceableEveItem
    {
        $item = new PriceableEveItem($this->type);
        $item->amount = $this->quantity;
        return $item;
    }

    public static function formatOrderItemsList($order)
    {
        $items = $order->items;
        if ($items->count() > 1) {
            $item_text = $items
                ->take(3)
                ->map(function ($item) {
                    $name = $item->type->typeName;
                    return "$item->quantity $name";
                })->implode(", ");
            $count = $items->count();
            if ($count > 3) {
                $count -= 3;
                $item_text .= trans('seat-industry::ai-common.other_label', ['count' => $count]);
            }
            return $item_text;
        } else if ($items->count() == 1) {
            $item = $items->first();
            $name = $item->type->typeName;
            return "$item->quantity $name";
        } else {
            return trans('seat-industry::ai-orders.invalid_order_label');
        }
    }

    public static function formatOrderItemsForDiscord($order)
    {
        return $order->items->sortBy(function ($item) {
            return $item->type->typeName;
        })->map(function ($item) {
            return "- " . $item->type->typeName . " " . "x" . $item->quantity;
        })->join("\n");
    }

    /**
     * @return int The eve type id of this object
     */
    public function getTypeID(): int
    {
        return $this->type_id;
    }

    public function unitPrice(): float
    {
        return $this->unit_price / 100;
    }

    public function assignedQuantity()
    {
        return $this->deliveryItems->sum("quantity_delivered");
    }

    public function availableQuantity()
    {
        return $this->quantity - $this->assignedQuantity();
    }
}