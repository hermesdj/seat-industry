<?php

namespace Seat\HermesDj\Industry\Helpers\Profile;

use Illuminate\Support\Collection;
use Seat\Eveapi\Models\Sde\DgmTypeAttribute;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\HermesDj\Industry\Models\Dogma\DogmaTypeEffect;

class IndustryRig
{
    private InvType $type;

    private Collection $attributes;

    private Collection $effects;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public static function loadIndustryRig(int $typeId): ?IndustryRig
    {
        $type = InvType::find($typeId);
        if (! $type) {
            return null;
        }

        $rig = new IndustryRig($type);
        $rig->loadAttributes();
        $rig->loadEffects();

        return $rig;
    }

    protected function loadAttributes(): void
    {
        $this->attributes = DgmTypeAttribute::where('typeID', $this->type->getTypeID())->all();
    }

    protected function loadEffects(): void
    {
        $this->effects = DogmaTypeEffect::where('typeID', $this->type->getTypeID())->all();
    }
}
