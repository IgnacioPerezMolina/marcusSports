<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain\Repository;

use MarcusSports\Catalog\PriceModifier\Domain\PriceModifier;

interface PriceModifierRepository
{
    public function save(PriceModifier $priceModifier): void;

    public function findAll(): array;
}