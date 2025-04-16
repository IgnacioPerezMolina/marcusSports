<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain\Repository;

use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRule;

interface PriceModifierRepository
{
    public function save(CompatibilityRule $compatibilityRule): void;
}