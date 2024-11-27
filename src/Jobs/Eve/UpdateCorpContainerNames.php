<?php

namespace Seat\HermesDj\Industry\Jobs\Eve;

use Illuminate\Support\Facades\Log;
use Seat\Eveapi\Jobs\AbstractAuthCorporationJob;
use Seat\Eveapi\Models\Assets\CorporationAsset;

class UpdateCorpContainerNames extends AbstractAuthCorporationJob
{
    /**
     * @var string
     */
    protected $method = 'post';

    /**
     * @var string
     */
    protected $endpoint = '/corporations/{corporation_id}/assets/names/';

    /**
     * @var string
     */
    protected $version = 'v1';

    /**
     * @var string
     */
    protected $scope = 'esi-assets.read_corporation_assets.v1';

    /**
     * @var array
     */
    protected $roles = ['Director'];

    /**
     * @var array
     */
    protected array $tags = ['corporation', 'asset', 'deployable'];

    protected int $item_id_limit = 1000;

    public function handle(): void
    {
        parent::handle();

        $marketGroups = [1651, 1652, 1653, 1657, 1658];

        // Get the assets for this corporation, chunked in a number of blocks
        // that the endpoint will accept.
        CorporationAsset::join('invTypes', 'type_id', '=', 'typeID')
            ->whereIn('marketGroupID', $marketGroups)
            ->where('corporation_id', $this->getCorporationId())
            ->where('is_singleton', true)// only singleton items may be named
            ->select('item_id')
            ->chunk($this->item_id_limit, function ($item_ids) {

                $this->request_body = $item_ids->pluck('item_id')->all();

                $response = $this->retrieve([
                    'corporation_id' => $this->getCorporationId(),
                ]);

                $names = collect($response->getBody());
                Log::debug($names);

                $names->each(function ($name) {
                    // "None" seems to indidate that no name is set.
                    if ($name->name === 'None')
                        return;


                    CorporationAsset::where('corporation_id', $this->getCorporationId())
                        ->where('item_id', $name->item_id)
                        ->update(['name' => $name->name]);
                });
            });
    }
}