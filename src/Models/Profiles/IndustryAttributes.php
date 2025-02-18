<?php

namespace Seat\HermesDj\Industry\Models\Profiles;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\HasCompositePrimaryKey;
use Seat\Eveapi\Traits\IsReadOnly;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;

class IndustryAttributes extends Model
{
    use HasCompositePrimaryKey;
    use IsReadOnly;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'seat_industry_attributes';

    protected $primaryKey = ['activity_type', 'production_type', 'bonus_type'];

    protected $fillable = [
        'activity_type',
        'production_type',
        'bonus_type',
        'attribute_id'
    ];

    protected $casts = [
        'activity_type' => ActivityTypeEnum::class,
        'bonus_type' => StructureBonusTypeEnum::class,
        'production_type' => ProductionTypeEnum::class
    ];
}