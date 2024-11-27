<?php

namespace Seat\HermesDj\Industry\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use RecursiveTree\Seat\TreeLib\Items\ToEveItem;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\HermesDj\Industry\IndustrySettings;
use Seat\HermesDj\Industry\Item\PriceableEveItem;
use Seat\HermesDj\Industry\Models\Deliveries\DeliveryItem;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityProducts;
use Seat\HermesDj\Industry\Models\Industry\IndustryBlueprints;
use Seat\HermesDj\Industry\Models\Inv\InvMetaTypes;
use Seat\Services\Contracts\HasTypeID;

class OrderItem extends Model implements HasTypeID, ToEveItem
{
    public $timestamps = false;

    protected $table = 'seat_industry_order_items';

    public function type(): HasOne
    {
        return $this->hasOne(InvType::class, 'typeID', 'type_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function deliveryItems(): HasMany
    {
        return $this->hasMany(DeliveryItem::class, 'order_item_id', 'id');
    }

    public function toEveItem(): PriceableEveItem
    {
        $item = new PriceableEveItem($this->type);
        $item->amount = $this->quantity;

        return $item;
    }

    public static function formatOrderItemsList($order): string
    {
        $items = $order->items;
        if ($items->count() > 1) {
            $item_text = $items
                ->take(3)
                ->map(function ($item) {
                    $name = $item->type->typeName;

                    return "$item->quantity $name";
                })->implode(', ');
            $count = $items->count();
            if ($count > 3) {
                $count -= 3;
                $item_text .= trans('seat-industry::ai-common.other_label', ['count' => $count]);
            }

            return $item_text;
        } elseif ($items->count() == 1) {
            $item = $items->first();
            $name = $item->type->typeName;

            return "$item->quantity $name";
        } else {
            return trans('seat-industry::ai-orders.invalid_order_label');
        }
    }

    public static function formatOrderItemsForDiscord($order): string
    {
        return $order->items->sortBy(function ($item) {
            return $item->type->typeName;
        })->map(function ($item) {
            return '- ' . $item->type->typeName . ' ' . 'x' . $item->quantity;
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

    public function assignedQuantity(): int
    {
        return $this->deliveryItems->sum('quantity_delivered');
    }

    public function availableQuantity(): int
    {
        return $this->quantity - $this->assignedQuantity();
    }

    private static function getBlueprintId($typeId)
    {
        $blueprintId = $typeId;
        if (!IndustryBlueprints::where('typeID', $blueprintId)->exists()) {
            // Go get the blueprint
            $blueprintType = IndustryActivityProducts::where('productTypeID', $typeId)->where('activityID', ActivityTypeEnum::MANUFACTURING)->first();
            if (!$blueprintType) return 0;
            $blueprintId = $blueprintType->typeID;
        }
        return $blueprintId;
    }

    public function detectMetaTypeState(): void
    {
        $allowedMetaTypes = IndustrySettings::$ALLOWED_META_TYPES->get([]);
        $metaType = InvMetaTypes::where('typeID', $this->type_id)->first();

        if (is_null($metaType)) {
            $this->rejected = false;
        } else {
            $metaGroup = $metaType->metaGroup()->first();
            $this->rejected = collect($allowedMetaTypes)->filter(function ($metaGroupID) use ($metaGroup) {
                return $metaGroupID == $metaGroup->metaGroupID;
            })->isEmpty();
        }

        $blueprint = self::getBlueprintId($this->type_id);

        $this->rejected = $blueprint == 0;
    }
}
