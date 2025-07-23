<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Stocks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Seat\Eveapi\Models\Assets\CharacterAsset;
use Seat\Eveapi\Models\Assets\CorporationAsset;
use Seat\Eveapi\Models\Industry\CharacterIndustryJob;
use Seat\Eveapi\Models\Industry\CorporationIndustryJob;
use Seat\HermesDj\Industry\Models\Orders\Order;

abstract class AbstractStocks
{
    public Collection $containers;

    public Collection $stocks;

    public Order $order;

    public function __construct($order)
    {
        $this->order = $order;
        $this->containers = collect();
        $this->stocks = collect();
    }

    public function getContainerIds(): Collection
    {
        return $this->containers->pluck('item_id');
    }

    protected function buildAssetsQuery(Builder $query): Builder
    {
        return $query->where('name', 'like', '%'.$this->order->order_id.'%')
            ->with(['type', 'type.group', 'station', 'structure', 'container', 'container.station', 'container.container', 'container.structure']);
    }

    protected function assetToStockItem(CharacterAsset|CorporationAsset $asset): StockItem
    {
        $stock = new StockItem;
        $stock->typeId = $asset->type->typeID;
        $stock->typeName = $asset->type->typeName;
        $stock->quantity = $asset->quantity;
        $stock->inProduction = false;
        $stock->containerId = $asset->container->item_id;
        $stock->locationId = $asset->container->location_id;

        return $stock;
    }

    protected function jobToStockItem(CharacterIndustryJob|CorporationIndustryJob $job): StockItem
    {
        $stock = new StockItem;
        $stock->typeId = $job->product->typeID;
        $stock->typeName = $job->product->typeName;
        $stock->blueprintId = $job->blueprint->typeID;
        $stock->inProduction = true;
        $stock->containerId = $job->output_location_id;
        $stock->locationId = $job->location_id || $job->station_id;
        $stock->quantity = $job->industryActivityProductManufacturing->quantity * $job->runs;

        return $stock;
    }

    abstract public function queryContainers(): void;

    abstract public function queryAssets(): void;
}
