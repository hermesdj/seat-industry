<?php

namespace Seat\HermesDj\Industry\Models\Dogma;

use Illuminate\Support\Collection;
use Seat\Eveapi\Traits\IsReadOnly;
use Seat\Services\Models\ExtensibleModel;
use Symfony\Component\Yaml\Yaml;

class DogmaEffect extends ExtensibleModel
{
    use IsReadOnly;

    public $incrementing = false;

    protected $table = 'dgmEffects';

    protected $primaryKey = 'effectId';

    public $timestamps = false;

    public function getModifierInfo(): Collection
    {
        if (strlen($this->modifierInfo) > 0) {
            return collect(Yaml::parse($this->modifierInfo));
        }

        return collect()();
    }
}
