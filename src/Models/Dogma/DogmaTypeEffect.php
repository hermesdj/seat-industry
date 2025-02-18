<?php

namespace Seat\HermesDj\Industry\Models\Dogma;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Seat\Eveapi\Traits\HasCompositePrimaryKey;
use Seat\Eveapi\Traits\IsReadOnly;
use Seat\Services\Models\ExtensibleModel;

class DogmaTypeEffect extends ExtensibleModel
{
    use HasCompositePrimaryKey;
    use IsReadOnly;

    public $incrementing = false;

    protected $table = 'dgmTypeEffects';

    protected $primaryKey = ['typeID', 'effectID'];

    public $timestamps = false;

    public function effect(): HasOne
    {
        return $this->hasOne(DogmaEffect::class, 'effectID', 'effectID');
    }
}
