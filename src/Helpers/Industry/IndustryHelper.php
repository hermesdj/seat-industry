<?php

namespace Seat\HermesDj\Industry\Helpers\Industry;

use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityProducts;
use Seat\HermesDj\Industry\Models\Industry\IndustryBlueprints;

class IndustryHelper
{
    public static function getManufacturingBlueprintId($typeId): int
    {
        $blueprintId = $typeId;
        if (!IndustryBlueprints::where('typeID', $blueprintId)->exists()) {
            // Go get the blueprint
            $blueprintType = IndustryActivityProducts::where('productTypeID', $typeId)->where('activityID', ActivityTypeEnum::MANUFACTURING)->first();
            if (!$blueprintType) {
                return -1;
            }
            $blueprintId = $blueprintType->typeID;
        }

        return $blueprintId;
    }

    public static function getReactionFormulaId($typeId): int
    {
        $reactionFormulaId = $typeId;
        if (!IndustryBlueprints::where('typeID', $reactionFormulaId)->exists()) {
            // Go get the blueprint
            $blueprintType = IndustryActivityProducts::where('productTypeID', $typeId)->where('activityID', ActivityTypeEnum::REACTION)->first();
            if (!$blueprintType) {
                return -1;
            }
            $reactionFormulaId = $blueprintType->typeID;
        }

        return $reactionFormulaId;
    }
}