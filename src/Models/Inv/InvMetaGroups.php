<?php

namespace Seat\HermesDj\Industry\Models\Inv;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Traits\IsReadOnly;

class InvMetaGroups extends Model
{
    use IsReadOnly;

    public $incrementing = false;

    protected $table = 'invMetaGroups';

    /**
     * @var string
     */
    protected $primaryKey = 'metaGroupID';
}
