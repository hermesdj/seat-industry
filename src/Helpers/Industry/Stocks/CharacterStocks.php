<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Stocks;

use Illuminate\Support\Collection;
use Seat\Eveapi\Models\Assets\CharacterAsset;
use Seat\Eveapi\Models\Industry\CharacterIndustryJob;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Web\Models\User;

class CharacterStocks extends AbstractStocks
{
    public User $user;

    public Collection $characterIds;

    public function __construct(Order $order, User $user)
    {
        parent::__construct($order);
        $this->user = $user;
    }

    public static function init(Order $order, User $user): CharacterStocks
    {
        $stocks = new CharacterStocks($order, $user);
        $stocks->characterIds = $user->characters()->get()->pluck('character_id');

        return $stocks;
    }

    public function queryContainers(): void
    {
        $containerQuery = CharacterAsset::whereIn('character_id', $this->characterIds);
        $containerQuery = $this->buildAssetsQuery($containerQuery);

        $this->containers = $containerQuery->get();
    }

    public function queryAssets(): void
    {
        if ($this->containers->isEmpty()) {
            $this->stocks = collect();

            return;
        }

        $this->stocks = collect();

        $assets = CharacterAsset::where('character_id', $this->characterIds)
            ->whereIn('location_id', $this->getContainerIds())
            ->with('type', 'container')
            ->get()
            ->map(function (CharacterAsset $item) {
                return $this->assetToStockItem($item);
            });

        foreach ($assets as $stock) {
            if (! $this->stocks->has($stock->typeId)) {
                $this->stocks->put($stock->typeId, collect());
            }
            $this->stocks->get($stock->typeId)->push($stock);
        }

        $jobs = CharacterIndustryJob::where('character_id', $this->characterIds)
            ->where('status', 'delivered')
            ->where('activity_id', ActivityTypeEnum::MANUFACTURING)
            ->whereIn('output_location_id', $this->getContainerIds())
            ->with('blueprint', 'product', 'industryActivityProductManufacturing')
            ->get()
            ->map(function (CharacterIndustryJob $item) {
                return $this->jobToStockItem($item);
            });

        foreach ($jobs as $stock) {
            if (! $this->stocks->has($stock->typeId)) {
                $this->stocks->put($stock->typeId, collect());
            }
            $this->stocks->get($stock->typeId)->push($stock);
        }
    }
}
