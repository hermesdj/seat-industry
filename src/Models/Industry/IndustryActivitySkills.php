<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryActivitySkills extends Model
{
    use IsReadOnly;

    protected $table = 'industryActivitySkills';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * typeID is the blueprint typeid in invTypes
     */
    public function getTypeID(): int
    {
        return $this->typeID;
    }

    /**
     * activity type id is either copy/improve/invention etc. See ActivityTypeEnum
     */
    public function getActivityID(): ActivityTypeEnum
    {
        return $this->activityID;
    }

    /**
     * Return the ID of the skill required to run the job
     */
    public function getSkillID(): int
    {
        return $this->skillID;
    }

    /**
     * Return the level of the skill needed
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}
