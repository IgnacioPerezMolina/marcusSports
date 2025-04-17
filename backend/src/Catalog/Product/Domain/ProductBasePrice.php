<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\Exception\OutOfBoundsException;
use MarcusSports\Shared\Domain\ValueObject\FloatValueObject;
use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class ProductBasePrice extends FloatValueObject
{
    private const MIN_PRICE = 0.0;
    private const MAX_PRICE = 1000000.0;
    private const DECIMAL_PRECISION = 2;

    public function __construct(float $value)
    {
        $value = round($value, self::DECIMAL_PRECISION);

        $this->ensureIsValid($value);
        parent::__construct($value);
    }

    private function ensureIsValid(float $value): void
    {
        if ($value < self::MIN_PRICE) {
            throw new InvalidArgumentException('Product base price cannot be negative.');
        }

        if ($value > self::MAX_PRICE) {
            throw new OutOfBoundsException(
                sprintf('Product base price cannot exceed %.2f.', self::MAX_PRICE)
            );
        }
    }
}