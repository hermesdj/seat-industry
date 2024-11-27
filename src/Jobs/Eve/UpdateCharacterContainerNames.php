<?php

namespace Seat\HermesDj\Industry\Jobs\Eve;

use Exception;
use Seat\Eveapi\Jobs\AbstractAuthCharacterJob;
use Seat\Eveapi\Models\Assets\CharacterAsset;
use Throwable;

class UpdateCharacterContainerNames extends AbstractAuthCharacterJob
{
    /**
     * @var string
     */
    protected $method = 'post';

    /**
     * @var string
     */
    protected $endpoint = '/characters/{character_id}/assets/names/';

    /**
     * @var string
     */
    protected $version = 'v1';

    /**
     * @var string
     */
    protected $scope = 'esi-assets.read_assets.v1';

    /**
     * @var array
     */
    protected $tags = ['character', 'asset'];

    /**
     * The maximum number of itemids we can request name
     * information for.
     *
     * @var int
     */
    protected int $item_id_limit = 1000;

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws Exception|Throwable
     */
    public function handle(): void
    {
        parent::handle();

        $marketGroups = [1651, 1652, 1653, 1657, 1658];

        // Get the assets for this character, chunked in a number of blocks
        // that the endpoint will accept.
        CharacterAsset::join('invTypes', 'type_id', '=', 'typeID')
            ->whereIn('marketGroupID', $marketGroups)
            ->where('character_id', $this->getCharacterId())
            ->where('is_singleton', true) // only singleton items may be named
            ->select('item_id')
            ->chunk($this->item_id_limit, function ($item_ids) {

                $this->request_body = $item_ids->pluck('item_id')->all();

                $response = $this->retrieve([
                    'character_id' => $this->getCharacterId(),
                ]);

                $names = collect($response->getBody());

                $names->each(function ($name) {

                    // "None" seems to indicate that no name is set.
                    if ($name->name === 'None')
                        return;

                    CharacterAsset::where('character_id', $this->getCharacterId())
                        ->where('item_id', $name->item_id)
                        ->update(['name' => $name->name]);
                });
            });
    }
}