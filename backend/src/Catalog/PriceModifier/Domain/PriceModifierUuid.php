<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

final class PriceModifierUuid extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}