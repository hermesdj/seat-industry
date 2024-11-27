<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Skills;

class IndustrySkillItem
{
    public int $characterId;

    public int $typeId;

    public int $blueprintId;

    public int $skillId;

    public int $requiredLevel;

    public int $currentLevel;

    public function hasSkillLevel(): bool
    {
        return $this->currentLevel >= $this->requiredLevel;
    }
}
