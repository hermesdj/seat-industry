<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Stocks;

use Seat\Eveapi\Models\Assets\CorporationAsset;
use Seat\Eveapi\Models\Industry\CorporationIndustryJob;
use Seat\HermesDj\Industry\Models\Orders\Order;

class CorporationStocks extends AbstractStocks
{
    public int $corporation_id;

    public function __construct(int $corporation_id, Order $order)
    {
        parent::__construct($order);
        $this->corporation_id = $corporation_id;
    }

    public static function init(int $corporation_id, Order $order): CorporationStocks
    {
        return new CorporationStocks($corporation_id, $order);
    }

    public function queryContainers(): void
    {
        $containerQuery = CorporationAsset::where('corporation_id', $this->corporation_id);
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

        $assets = CorporationAsset::where('corporation_id', $this->corporation_id)
            ->whereIn('location_id', $this->getContainerIds())
            ->with('type', 'container')
            ->get()
            ->map(function (CorporationAsset $item) {
                return $this->assetToStockItem($item);
            });

        foreach ($assets as $stock) {
            if (! $this->stocks->has($stock->typeId)) {
                $this->stocks->put($stock->typeId, collect());
            }
            $this->stocks->get($stock->typeId)->push($stock);
        }

        $jobs = CorporationIndustryJob::where('corporation_id', $this->corporation_id)
            ->where('status', 'active')
            ->whereIn('output_location_id', $this->getContainerIds())
            ->with('blueprint', 'product', 'industryActivityProductManufacturing')
            ->get()
            ->map(function (CorporationIndustryJob $item) {
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
