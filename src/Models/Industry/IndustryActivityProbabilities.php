<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryActivityProbabilities extends Model
{
    use IsReadOnly;

    protected $table = "industryActivityProbabilities";

    public $incrementing = false;
    public $timestamps = false;

    /**
     * typeID is the blueprint typeid in invTypes
     * @return int
     */
    public function getTypeID(): int
    {
        return $this->typeID;
    }

    /**
     * activity type id is either copy/improve/invention etc. See ActivityTypeEnum
     * @return ActivityTypeEnum
     */
    public function getActivityID(): ActivityTypeEnum
    {
        return $this->activityID;
    }

    /**
     * type of product being invented
     * @return int
     */
    public function getProductTypeID(): int
    {
        return $this->productTypeID;
    }

    /**
     * the base probability unmodified to succeed in the invention
     * @return float
     */
    public function getProbability(): float
    {
        return $this->probability;
    }
}