<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Skills;

use Seat\Eveapi\Models\Character\CharacterSkill;
use Seat\HermesDj\Industry\Helpers\Industry\IndustryHelper;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivitySkills;

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

    public static function getReactionSkills($blueprintId)
    {
        return self::getIndustrySkillForItem($blueprintId, ActivityTypeEnum::REACTION)->get();
    }

    public static function hasRequiredManufacturingSkills($user, $typeId): IndustrySkillResult
    {
        $results = new IndustrySkillResult;
        $activityType = ActivityTypeEnum::MANUFACTURING;
        $blueprintId = IndustryHelper::getManufacturingBlueprintId($typeId);

        if (! $blueprintId) {
            $blueprintId = IndustryHelper::getReactionFormulaId($typeId);
            if ($blueprintId != null) {
                $activityType = ActivityTypeEnum::REACTION;
            } else {
                return $results;
            }
        }

        $skills = collect();
        $characterIds = $user->characters->pluck('character_id');

        if ($activityType == ActivityTypeEnum::MANUFACTURING) {
            $skills = self::getManufacturingSkills($blueprintId);
        } elseif ($activityType == ActivityTypeEnum::REACTION) {
            $skills = self::getReactionSkills($blueprintId);
        } else {
            return $results;
        }

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
                $result->activityType = $activityType;

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
            if (! $item->rejected) {
                $item->skills = self::hasRequiredManufacturingSkills($user, $item->type_id);
            } else {
                $item->skills = null;
            }
        }

        return $items;
    }
}
