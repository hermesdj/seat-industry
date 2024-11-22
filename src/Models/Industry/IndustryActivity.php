<?php

namespace Seat\HermesDj\Industry\Models\Industry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\HasCompositePrimaryKey;
use Seat\Eveapi\Traits\IsReadOnly;

class IndustryActivity extends Model
{
    use HasCompositePrimaryKey;
    use HasFactory;
    use IsReadOnly;

    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'industryActivity';

    protected $primaryKey = ['typeID', 'activityID'];

    protected $casts = [
        'activityID' => ActivityTypeEnum::class,
    ];

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
     * Base time before modifier for an industry job
     */
    public function getTime(): int
    {
        return $this->time;
    }
}
