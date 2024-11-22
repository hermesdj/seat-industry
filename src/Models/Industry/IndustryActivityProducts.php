<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryActivityProducts extends Model
{
    use IsReadOnly;

    protected $table = 'industryActivityProducts';

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
     * type of product being produced per run of blueprint
     */
    public function getProductTypeID(): int
    {
        return $this->productTypeID;
    }

    /**
     * The quantity of productTypeID produced per run of blueprint
     */
    public function getProducedQuantity(): int
    {
        return $this->quantity;
    }
}
