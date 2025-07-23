<?php

namespace Seat\HermesDj\Industry\Helpers\Industry;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Seat\HermesDj\Industry\IndustrySettings;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivity;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityProducts;
use Seat\HermesDj\Industry\Models\Industry\IndustryBlueprints;
use Seat\HermesDj\Industry\Models\Inv\InvMetaTypes;

class BuildPlanHelper
{
    private static function computeBuildPlan($items): Collection
    {
        $result = collect();
        Log::debug('=================================================');
        Log::debug('=================================================');
        Log::debug('=========== BEGIN INDUSTRY BUILD PLAN ===========');

        $typeIds = $items->collect()->pluck('type_id');
        // These give the per run how many is produced
        $activityProducts = IndustryActivityProducts::whereIn('productTypeID', $typeIds)->where('activityID', ActivityTypeEnum::MANUFACTURING)->get();
        $reactionProducts = IndustryActivityProducts::whereIn('productTypeID', $typeIds)->where('activityID', ActivityTypeEnum::REACTION)->get();
        // These give the max number of runs on a blueprint
        $blueprints = IndustryBlueprints::whereIn('typeID', $activityProducts->pluck('typeID'))->get();
        $formulas = IndustryBlueprints::whereIn('typeID', $reactionProducts->pluck('typeID'))->get();
        $metaTypes = InvMetaTypes::whereIn('typeID', $typeIds)->get();
        $industryActivities = IndustryActivity::whereIn('typeID', $activityProducts->pluck('typeID'))->where('activityID', ActivityTypeEnum::MANUFACTURING)->get();
        $reactionActivities = IndustryActivity::whereIn('typeID', $reactionProducts->pluck('typeID'))->where('activityID', ActivityTypeEnum::REACTION)->get();

        foreach ($items as $orderItem) {
            $type = $orderItem->type;
            $item = new EndProductItem;
            $item->productTypeId = $type->getTypeID();
            $item->productName = $type->typeName;
            $item->targetQuantity = $orderItem->quantity;

            Log::debug("=========== Ravworks: computing item with typeName $item->productName and quantity $item->targetQuantity");

            $metaType = $metaTypes->where('typeID', $item->productTypeId)->first();

            if (! self::isAllowed($metaType)) {
                Log::debug("No Allowed Item Meta Type $metaType->metaGroupID");

                continue;
            }

            if ($metaType) {
                $item->metaGroupId = $metaType->metaGroup->metaGroupID;
                $item->isTech2 = $item->metaGroupId == 2;
            } else {
                $item->isTech2 = false;
            }

            $activityProduct = $activityProducts->where('productTypeID', $item->productTypeId)->first();

            if ($activityProduct == null) {
                $activityProduct = $reactionProducts->where('productTypeID', $item->productTypeId)->first();

                if (! $activityProduct) {
                    continue;
                } else {
                    $item->activityType = ActivityTypeEnum::REACTION;
                }
            } else {
                $item->activityType = ActivityTypeEnum::MANUFACTURING;
            }

            $item->materialEfficiency = 10;

            if ($item->activityType == ActivityTypeEnum::REACTION) {
                $item->materialEfficiency = 0;
            }

            $item->blueprintTypeId = $activityProduct->typeID;
            $item->producedPerRun = $activityProduct->quantity;

            $industryActivity = null;

            if ($item->activityType == ActivityTypeEnum::MANUFACTURING) {
                $industryActivity = $industryActivities->where('typeID', $item->blueprintTypeId)->first();
            } elseif ($item->activityType == ActivityTypeEnum::REACTION) {
                $industryActivity = $reactionActivities->where('typeID', $item->blueprintTypeId)->first();
            } else {
                continue;
            }

            $item->manufacturingTimePerRun = $industryActivity->time;

            Log::debug("Produced per run is $item->producedPerRun");

            $blueprint = null;

            if ($item->activityType == ActivityTypeEnum::MANUFACTURING) {
                $blueprint = $blueprints->where('typeID', $item->blueprintTypeId)->first();
            } elseif ($item->activityType == ActivityTypeEnum::REACTION) {
                $blueprint = $formulas->where('typeID', $item->blueprintTypeId)->first();
            } else {
                continue;
            }

            if ($blueprint == null) {
                Log::debug("No IndustryBlueprint found for $item->productTypeId with blueprint id ".$item->blueprintTypeId);

                continue;
            }

            $item->excessProduction = $item->targetQuantity % $item->producedPerRun;
            $item->nbRuns = ($item->targetQuantity - $item->excessProduction) / $item->producedPerRun;

            if ($item->excessProduction > 0) {
                $item->nbRuns += 1;
            }

            if ($item->nbRuns == 0) {
                $item->nbRuns = 1;
            }
            Log::debug("NbRuns=$item->nbRuns, ExcessProduction=$item->excessProduction");

            $item->maxProdLimitPerBPC = $blueprint->maxProductionLimit;

            if ($item->nbRuns < $item->maxProdLimitPerBPC) {
                $itemOne = clone $item;
                $itemOne->nbTasks = 1;
                $result->push($itemOne);

                continue;
            }

            $itemTwo = clone $item;

            $excessRuns = $item->nbRuns % $item->maxProdLimitPerBPC;
            $itemTwo->nbTasks = ($item->nbRuns - $excessRuns) / $item->maxProdLimitPerBPC;
            Log::debug("MaxProdPerBPC=$item->maxProdLimitPerBPC, NbTasks=$itemTwo->nbTasks, ExcessRuns=$excessRuns");

            if ($itemTwo->nbTasks > 0) {
                $itemTwo->nbRuns = $item->maxProdLimitPerBPC;
                $result->push($itemTwo);
            }

            if ($excessRuns > 0) {
                $itemThree = clone $item;
                $itemThree->nbTasks = 1;
                $itemThree->nbRuns = $excessRuns;
                $result->push($itemThree);
            }
        }

        return $result;
    }

    public static function computeOrderBuildPlan($order): Collection
    {
        $orderItems = $order->allowedItems()->get()
            ->filter(function ($item) {
                return $item->availableQuantity() > 0;
            })->map(function ($item) {
                $item->quantity = $item->availableQuantity();

                return $item;
            });

        return self::computeBuildPlan($orderItems);
    }

    public static function computeDeliveryBuildPlan($delivery): Collection
    {
        $orderItems = $delivery->deliveryItems()->get()
            ->filter(function ($d) {
                return ! $d->orderItem->rejected && $d->quantity_delivered > 0;
            })
            ->filter(function ($item) {
                return ! $item->completed;
            })
            ->map(function ($d) {
                $orderItem = $d->orderItem;
                $orderItem->quantity = $d->quantity_delivered;

                return $orderItem;
            });

        return self::computeBuildPlan($orderItems);
    }

    private static function isAllowed($metaType): bool
    {
        $allowedMetaGroups = collect(IndustrySettings::$ALLOWED_META_TYPES);

        return $metaType == null || $allowedMetaGroups->contains($metaType->metaGroupID);
    }
}
