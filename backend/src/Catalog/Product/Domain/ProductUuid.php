<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

final class ProductUuid extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}