<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\HasCompositePrimaryKey;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryActivity extends Model
{
    use HasCompositePrimaryKey;
    use IsReadOnly;
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'industryActivity';
    protected $primaryKey = ['typeID', 'activityID'];

    protected $casts = [
        "activityID" => ActivityTypeEnum::class
    ];

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
     * Base time before modifier for an industry job
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }
}