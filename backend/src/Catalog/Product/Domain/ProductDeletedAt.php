<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Domain;

use DateTimeImmutable;
use MarcusSports\Shared\Domain\ValueObject\NullableDateTimeImmutableValueObject;

class ProductDeletedAt extends NullableDateTimeImmutableValueObject
{
    public function __construct(?DateTimeImmutable $value)
    {
        parent::__construct($value);
    }
}