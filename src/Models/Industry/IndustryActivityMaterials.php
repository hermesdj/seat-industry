<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryActivityMaterials extends Model
{
    use IsReadOnly;

    protected $table = 'industryActivityMaterials';

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
     * type of material used in industry activity from invTypes
     */
    public function getMaterialTypeID(): int
    {
        return $this->materialTypeID;
    }

    /**
     * The quantity of materialTypeID consumed before modifiers
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
