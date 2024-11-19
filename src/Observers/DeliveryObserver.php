<?php

namespace HermesDj\Seat\Industry\Observers;

use HermesDj\Seat\Industry\Models\Statistics\DeliveryStatistic;
use RecursiveTree\Seat\TreeLib\Helpers\SeatInventoryPluginHelper;

class DeliveryObserver
{
    public static function saved($delivery)
    {
        self::updateOrderCompletionState($delivery);
    }

    public static function saving($delivery)
    {
        //delivery is completed, remove the virtual source
        if ($delivery->completed) {
            self::deleteInventorySource($delivery);
        } //create/update the delivery
        else {
            if (SeatInventoryPluginHelper::pluginIsAvailable()) {
                $order = $delivery->order;
                $source = $delivery->seatInventorySource;
                //check if we have to add a source
                if ($order->add_seat_inventory && $source === null) {
                    //TODO fix inventory integration
                    $workspace = SeatInventoryPluginHelper::$WORKSPACE_MODEL::where("name", "like", "%add2Industry%")->first();

                    if (!$workspace) return;

                    $user_name = $delivery->user->name;
                    $source = new SeatInventoryPluginHelper::$INVENTORY_SOURCE_MODEL();
                    $source->location_id = SeatInventoryPluginHelper::$LOCATION_MODEL::where("structure_id", $order->location_id)->orWhere("station_id", $order->location_id)->first()->id;
                    $source->source_name = "alliance-industry delivery (#$order->id) from $user_name";
                    $source->source_type = "alliance_industry_delivery";
                    $source->workspace_id = $workspace->id;
                    $source->save();

                    foreach ($order->items as $order_item) {
                        $item = new SeatInventoryPluginHelper::$INVENTORY_ITEM_MODEL();
                        $item->source_id = $source->id;
                        $item->type_id = $order_item->type_id;
                        $item->amount = $order_item->quantity * $order->quantity;
                        $item->save();
                    }

                    $delivery->seat_inventory_source = $source->id;
                }
            }
        }
    }

    public static function deleted($delivery): void
    {
        self::updateOrderCompletionState($delivery);
        self::deleteInventorySource($delivery);

        foreach ($delivery->deliveryItems as $item) {
            $item->delete();
        }

        DeliveryStatistic::create([
            'order_id' => $delivery->order_id,
            'delivery_id' => $delivery->id,
            'user_id' => $delivery->user_id,
            'accepted' => $delivery->accepted,
            'completed_at' => $delivery->completed_at
        ]);
    }

    private static function deleteInventorySource($delivery): void
    {
        if (SeatInventoryPluginHelper::pluginIsAvailable()) {
            if ($delivery->seatInventorySource) {
                foreach ($delivery->seatInventorySource->items as $item) {
                    $item->delete();
                }
                $delivery->seatInventorySource->delete();
                $delivery->seat_inventory_source = null;
            }
        }
    }

    private static function updateOrderCompletionState($delivery): void
    {
        $order = $delivery->order;

        //this is the case when the order observe triggers the deletion of related deliveries
        if (!$order) return;

        $is_completed = false;
        foreach ($order->deliveries as $delivery) {
            if (!$delivery->completed) {
                $is_completed = false;
                break;
            } else {
                $is_completed = true;
            }
        }

        if ($order->assignedQuantity() >= $order->totalQuantity() && $is_completed) {
            $order->completed = true;
            $order->completed_at = now();
        } else {
            $order->completed = false;
            $order->completed_at = null;
        }
        $order->save();
    }
}