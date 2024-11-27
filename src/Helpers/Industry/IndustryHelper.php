<?php

namespace Seat\HermesDj\Industry\Helpers\Industry;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivity;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityMaterials;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityProducts;
use Seat\HermesDj\Industry\Models\Industry\IndustryBlueprints;
use Seat\HermesDj\Industry\Models\Inv\InvMetaTypes;

class IndustryHelper
{
    private static array $allowedMetaGroupIds = [1, 2, 14, 53, 54];

    private static function computeBuildPlan($items): Collection
    {
        $result = collect();
        Log::debug("=================================================");
        Log::debug("=================================================");
        Log::debug("=========== BEGIN INDUSTRY BUILD PLAN ===========");

        $typeIds = $items->collect()->pluck('type_id');
        // These give the per run how many is produced
        $activityProducts = IndustryActivityProducts::whereIn('productTypeID', $typeIds)->where('activityID', ActivityTypeEnum::MANUFACTURING)->get();
        // These give the max number of runs on a blueprint
        $blueprints = IndustryBlueprints::whereIn('typeID', $activityProducts->pluck('typeID'))->get();
        $metaTypes = InvMetaTypes::whereIn('typeID', $typeIds)->get();
        $industryActivities = IndustryActivity::whereIn('typeID', $activityProducts->pluck('typeID'))->where('activityID', ActivityTypeEnum::MANUFACTURING)->get();

        foreach ($items as $orderItem) {
            $type = $orderItem->type;
            $item = new EndProductItem();
            $item->productTypeId = $type->getTypeID();
            $item->productName = $type->typeName;
            $item->targetQuantity = $orderItem->quantity;

            Log::debug("=========== Ravworks: computing item with typeName $item->productName and quantity $item->targetQuantity");

            $metaType = $metaTypes->where('typeID', $item->productTypeId)->first();

            if (!self::isAllowed($metaType)) {
                Log::debug("No Allowed Item Meta Type $metaType->metaGroupID");
                continue;
            }

            $activityProduct = $activityProducts->where('productTypeID', $item->productTypeId)->first();

            if ($activityProduct == null) {
                Log::debug("No IndustryActivityProduct found for productTypeId $item->productTypeId");
                continue;
            }

            $item->materialEfficiency = 0;
            $item->blueprintTypeId = $activityProduct->typeID;
            $item->producedPerRun = $activityProduct->quantity;

            $industryActivity = $industryActivities->where('typeID', $item->blueprintTypeId)->first();
            $item->manufacturingTimePerRun = $industryActivity->time;

            Log::debug("Produced per run is $item->producedPerRun");

            $blueprint = $blueprints->where('typeID', $item->blueprintTypeId)->first();

            if ($blueprint == null) {
                Log::debug("No IndustryBlueprint found for $item->productTypeId with blueprint id " . $item->blueprintTypeId);
                continue;
            }

            $item->excessProduction = $item->targetQuantity % $item->producedPerRun;
            $item->nbRuns = ($item->targetQuantity - $item->excessProduction) / $item->producedPerRun;
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
                $itemThree->excessRuns = $excessRuns;
                $result->push($itemThree);
            }
        }

        return $result;
    }

    public static function computeOrderBuildPlan($order): Collection
    {
        return self::computeBuildPlan($order->items);
    }

    public static function computeDeliveryBuildPlan($delivery): Collection
    {
        $orderItems = $delivery->deliveryItems()->get()->map(function ($d) {
            return $d->orderItem;
        });

        return self::computeBuildPlan($orderItems);
    }

    private static function isAllowed($metaType): bool
    {
        $allowedMetaGroups = collect(self::$allowedMetaGroupIds);
        return $metaType == null || $allowedMetaGroups->contains($metaType->metaGroupID);
    }

    private static function computeMaterialsRecursive($typeIds)
    {

    }

    public static function computeBuildPlanManufacturing(BuildPlan $buildPlan): Collection
    {
        $result = collect();
        $blueprintIds = $buildPlan->getEndProducts()->pluck('blueprintTypeId');
        $activityMaterials = IndustryActivityMaterials::whereIn('typeID', $blueprintIds)->where('activityID', ActivityTypeEnum::MANUFACTURING)->get();

        foreach ($buildPlan->getEndProducts() as $endProduct) {
            $materials = $activityMaterials->where('typeID', $endProduct->blueprintTypeId)->all();
            $materialTypeIds = collect($materials)->pluck('materialTypeID');
            $types = InvType::whereIn('typeID', $materialTypeIds)->get();
        }

        return $result;
    }
}