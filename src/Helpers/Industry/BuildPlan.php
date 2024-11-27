<?php

namespace Seat\HermesDj\Industry\Helpers\Industry;

use Illuminate\Support\Collection;
use Seat\HermesDj\Industry\Helpers\Industry\Stocks\CharacterStocks;
use Seat\HermesDj\Industry\Helpers\Industry\Stocks\CorporationStocks;
use Seat\HermesDj\Industry\Helpers\Industry\Stocks\StocksHelper;
use Seat\HermesDj\Industry\Helpers\Ravworks\RavworksHelper;
use Seat\HermesDj\Industry\Models\Orders\Order;

class BuildPlan
{
    private Order $order;

    private Collection $endProducts;

    private CharacterStocks $personalStock;

    private CorporationStocks $corporationStock;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getEndProducts(): Collection
    {
        return $this->endProducts;
    }

    public function getPersonalStocks(): CharacterStocks
    {
        return $this->personalStock;
    }

    public function getCorporationStocks(): CorporationStocks
    {
        return $this->corporationStock;
    }

    public function hasProduction(): bool
    {
        return $this->endProducts->isNotEmpty();
    }

    public function hasPersonalStocks(): bool
    {
        return $this->personalStock->stocks->isNotEmpty();
    }

    public function hasCorporationStocks(): bool
    {
        return $this->corporationStock->stocks->isNotEmpty();
    }

    public function computeBuildPlan(): void
    {
        $this->endProducts = IndustryHelper::computeOrderBuildPlan($this->order);
    }

    public function computeBuildPlanForDelivery($delivery): void
    {
        if ($delivery->order_id == $this->order->id) {
            $this->endProducts = IndustryHelper::computeDeliveryBuildPlan($delivery);
        } else {
            $this->endProducts = collect();
        }
    }

    public function computeBuildPlanManufacturing(): void
    {
        if ($this->endProducts->count() === 0) {
            $this->computeBuildPlan();
        }

        $this->stocks = IndustryHelper::computeBuildPlanManufacturing($this);
    }

    public function computeOrderStocks($user): void
    {
        $this->personalStock = StocksHelper::computePersonalStocks($user, $this->order);
        $this->corporationStock = StocksHelper::computeCorporationStocks($user->main_character->affiliation->corporation_id, $this->order);
    }

    public function toRavworksText(): string
    {
        return RavworksHelper::printOrderBuildPlanText($this);
    }

    public function toRavworksHtml(): string
    {
        return RavworksHelper::printOrderBuildPlanHtml($this);
    }

    public function toRavworksPersonalStockText(): string
    {
        return RavworksHelper::printPersonalOrderStocksText($this);
    }

    public function toRavworksPersonalStockHtml(): string
    {
        return RavworksHelper::printPersonalOrderStocksHtml($this);
    }

    public function toRavworksCorporationStockText(): string
    {
        return RavworksHelper::printCorporationOrderStocksText($this);
    }

    public function toRavworksCorporationStockHtml(): string
    {
        return RavworksHelper::printCorporationOrderStocksHtml($this);
    }
}