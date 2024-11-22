<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryBlueprints extends Model
{
    use IsReadOnly;

    protected $table = "industryActivityProbabilities";

    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = "typeID";

    /**
     * typeID is the blueprint typeid in invTypes
     * @return int
     */
    public function getTypeID(): int
    {
        return $this->typeID;
    }

    /**
     * How many blueprint runs can be on a BPC
     * @return int
     */
    public function getMaxProductionLimit(): int
    {
        return $this->maxProductionLimit;
    }
}