<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Domain;

use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class ProductDescription extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}