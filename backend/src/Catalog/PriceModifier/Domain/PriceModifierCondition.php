<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain;

use MarcusSports\Shared\Domain\ValueObject\JsonStringValueObject;
use InvalidArgumentException;

final class PriceModifierCondition extends JsonStringValueObject
{
    protected function validate(array $value): void
    {
        if (!isset($value['if'])) {
            throw new InvalidArgumentException('The price modifier condition must include an "if" clause.');
        }
    }
}
