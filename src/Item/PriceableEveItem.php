<?php

namespace HermesDj\Seat\Industry\Item;

use HermesDj\Seat\TreeLib\Items\EveItem;
use Seat\Services\Contracts\IPriceable;

class PriceableEveItem extends EveItem implements IPriceable
{
    public function getTypeID(): int
    {
        return $this->typeModel->typeID;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
        $this->marketPrice = $price / $this->getAmount();
    }
}