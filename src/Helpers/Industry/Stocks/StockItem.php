<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Stocks;

class StockItem
{
    public int $typeId;
    public string $typeName;
    public int $blueprintId;
    public int $quantity;
    public bool $inProduction;
    public int $locationId;
    public int $containerId;
}