<?php

namespace Seat\HermesDj\Industry\Models\Profiles;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\HasCompositePrimaryKey;
use Seat\Eveapi\Traits\IsReadOnly;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;

class IndustryStructureBonus extends Model
{
    use HasCompositePrimaryKey;
    use IsReadOnly;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'seat_industry_structure_bonuses';

    protected $primaryKey = ['structure_type_id', 'activity_type', 'bonus_type'];

    protected $fillable = [
        'structure_type_id',
        'activity_type',
        'bonus_type',
        'float_value'
    ];

    protected $casts = [
        'activity_type' => ActivityTypeEnum::class,
        'bonus_type' => StructureBonusTypeEnum::class
    ];
}