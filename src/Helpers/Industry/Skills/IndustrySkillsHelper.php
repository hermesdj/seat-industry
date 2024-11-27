<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Skills;

use Seat\Eveapi\Models\Character\CharacterSkill;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityProducts;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivitySkills;
use Seat\HermesDj\Industry\Models\Industry\IndustryBlueprints;

class IndustrySkillsHelper
{
    public static function getIndustrySkillForItem($blueprintId, $activityId)
    {
        return IndustryActivitySkills::where('typeID', $blueprintId)->where('activityID', $activityId);
    }

    public static function getManufacturingSkills($blueprintId)
    {
        return self::getIndustrySkillForItem($blueprintId, ActivityTypeEnum::MANUFACTURING)->get();
    }

    private static function getBlueprintId($typeId)
    {
        $blueprintId = $typeId;
        if (!IndustryBlueprints::where('typeID', $blueprintId)->exists()) {
            // Go get the blueprint
            $blueprintType = IndustryActivityProducts::where('productTypeID', $typeId)->where('activityID', ActivityTypeEnum::MANUFACTURING)->first();
            if (!$blueprintType) {
                return collect();
            }
            $blueprintId = $blueprintType->typeID;
        }

        return $blueprintId;
    }

    public static function hasRequiredManufacturingSkills($user, $typeId): IndustrySkillResult
    {
        $results = new IndustrySkillResult;
        $blueprintId = self::getBlueprintId($typeId);
        $skills = self::getManufacturingSkills($blueprintId);
        $characterIds = $user->characters->pluck('character_id');
        foreach ($skills as $skill) {
            // skillID & level
            $characterSkills = CharacterSkill::whereIn('character_id', $characterIds)->where('skill_id', $skill->skillID)->get();

            foreach ($characterSkills as $characterSkill) {
                $result = new IndustrySkillItem;
                $result->typeId = $typeId;
                $result->blueprintId = $blueprintId;
                $result->characterId = $characterSkill->character_id;
                $result->skillId = $characterSkill->skill_id;
                $result->currentLevel = $characterSkill->active_skill_level;
                $result->requiredLevel = $skill->level;

                if ($result->hasSkillLevel()) {
                    $results->skills->push($result);
                } else {
                    $results->missingSkills->push($result);
                }
            }
        }

        return $results;
    }

    public static function computeManufacturingSkillsForOrderItems($user, $items)
    {
        foreach ($items as $item) {
            if (!$item->rejected) {
                $item->skills = self::hasRequiredManufacturingSkills($user, $item->type_id);
            } else {
                $item->skills = null;
            }
        }

        return $items;
    }
}
