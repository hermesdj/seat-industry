<?php

namespace Seat\HermesDj\Industry\Models\Profiles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Seat\Eveapi\Models\Alliances\Alliance;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Web\Models\User;

class IndustryProfile extends Model
{
    public $timestamps = true;
    protected $table = 'seat_industry_profiles';

    protected $fillable = [
        'scope',
        'user_id',
        'corp_id',
        'alliance_id',
        'name'
    ];

    /**
     * @return void
     */
    public function loadProfileData(): void
    {
        foreach ($this->structures() as $structure) {
            $structure->loadStructureData();
        }
    }

    /**
     * @return HasManyThrough
     */
    public function structures(): HasManyThrough
    {
        return $this->hasManyThrough(IndustryStructure::class, IndustryProfileStructure::class, 'profile_id', 'id', 'id', 'structure_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(CorporationInfo::class, 'corp_id', 'corporation_id');
    }

    public function alliance(): BelongsTo
    {
        return $this->belongsTo(Alliance::class, 'alliance_id', 'alliance_id');
    }

    public static function getPersonalProfiles(): Builder
    {
        return self::where('scope', 'personal')->where('user_id', auth()->user()->id);
    }

    public static function getCorporationProfiles(): Builder
    {
        $corpIds = auth()->user()->characters->map(function ($char) {
            return $char->affiliation->corporation_id;
        });

        return self::where('scope', 'corporation')->whereIn('corp_id', $corpIds);
    }

    public static function getAllianceProfiles(): Builder
    {
        $allianceIds = auth()->user()->characters->map(function ($char) {
            return $char->affiliation->alliance_id;
        });

        return self::where('scope', 'alliance')->whereIn('alliance_id', $allianceIds);
    }

    public static function getPublicProfiles(): Builder
    {
        return self::where('scope', 'public');
    }

    public static function loadAll(): object
    {
        return (object)[
            'public' => self::getPublicProfiles()->get(),
            'alliance' => self::getAllianceProfiles()->get(),
            'corporation' => self::getCorporationProfiles()->get(),
            'personal' => self::getPersonalProfiles()->get()
        ];
    }
}