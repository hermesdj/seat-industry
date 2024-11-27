<?php

namespace Seat\HermesDj\Industry\Models\Inv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Seat\Eveapi\Traits\IsReadOnly;

class InvMetaTypes extends Model
{
    use IsReadOnly;

    public $incrementing = false;

    protected $table = 'invMetaTypes';

    /**
     * @var string
     */
    protected $primaryKey = 'typeID';

    public function metaGroup(): HasOne
    {
        return $this->hasOne(InvMetaGroups::class, 'metaGroupID', 'metaGroupID');
    }
}
