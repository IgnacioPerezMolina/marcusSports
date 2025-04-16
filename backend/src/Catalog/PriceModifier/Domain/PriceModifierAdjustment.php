<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain;

use MarcusSports\Shared\Domain\ValueObject\FloatValueObject;
use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;

final class PriceModifierAdjustment extends FloatValueObject
{
    public function __construct(float $value)
    {
        // You might allow negative (for discounts)
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('The price modifier adjustment must be numeric.');
        }
        parent::__construct($value);
    }
}
