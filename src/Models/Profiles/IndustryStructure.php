<?php

namespace Seat\HermesDj\Industry\Models\Profiles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Seat\HermesDj\Industry\Helpers\Profile\IndustryRig;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;

class IndustryStructure extends Model
{
    public $timestamps = false;

    protected $table = 'seat_industry_structures';

    protected $fillable = [
        'structure_id',
        'name',
        'structureType',
        'system_id',
        'rig1_type_id',
        'rig2_type_id',
        'rig3_type_id'
    ];

    /**
     *
     * @var Collection $structureBonuses
     */
    protected Collection $structureBonuses;

    protected Collection $structureRigs;

    public function loadStructureData(): void
    {
        $this->loadStructureBonuses();
        $this->loadRigBonuses();
    }

    public function loadStructureBonuses(): void
    {
        $this->structureBonuses = $this->bonuses()->get();
    }

    public function loadRigBonuses(): void
    {
        if ($this->rig1_type_id) {
            $this->loadIndustryRig($this->rig1_type_id);
        }

        if ($this->rig2_type_id) {
            $this->loadIndustryRig($this->rig2_type_id);
        }

        if ($this->rig3_type_id) {
            $this->loadIndustryRig($this->rig3_type_id);
        }

        foreach ($this->structureRigs as $rig) {

        }
    }

    protected function loadIndustryRig($typeId): void
    {
        $rig = IndustryRig::loadIndustryRig($typeId);

        if (!is_null($rig)) {
            $this->structureRigs->push($rig);
        }
    }

    public function getStructureBonus(ActivityTypeEnum $activityType, StructureBonusTypeEnum $bonusType): float
    {
        $bonus = $this->structureBonuses->where('activity_type', $activityType)->where('bonus_type', $bonusType)->first();

        return $bonus ? $bonus->float_value : 0.0;
    }

    public function getRigBonus(ActivityTypeEnum $activityType, StructureBonusTypeEnum $bonusType): float
    {

        return 0.0;
    }

    public function getFullBonus(ActivityTypeEnum $activityType, StructureBonusTypeEnum $bonusType): float
    {

        return 0.0;
    }

    public function bonuses(): HasMany
    {
        return $this->hasMany(IndustryStructureBonus::class, 'structure_id', 'id');
    }
}