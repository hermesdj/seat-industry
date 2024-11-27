<?php

namespace Seat\HermesDj\Industry\Helpers\Industry;

class EndProductItem
{
    public int $productTypeId;

    public string $productName;

    public int $targetQuantity;

    public int $materialEfficiency;

    public int $blueprintTypeId;

    public int $producedPerRun;

    public int $manufacturingTimePerRun;

    public int $excessProduction;

    public int $nbRuns;

    public int $maxProdLimitPerBPC;

    public int $nbTasks;
}
