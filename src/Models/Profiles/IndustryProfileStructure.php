<?php

namespace Seat\HermesDj\Industry\Models\Profiles;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\HasCompositePrimaryKey;

class IndustryProfileStructure extends Model
{
    use HasCompositePrimaryKey;

    public $incrementing = false;

    protected $table = 'seat_industry_profiles';

    protected $fillable = [
        'profile_id',
        'structure_id',
        'production_type',
    ];

    protected $primaryKey = ['profile_id', 'structure_id'];
}
