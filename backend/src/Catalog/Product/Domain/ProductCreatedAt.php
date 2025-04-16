<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Domain;

use DateTime;
use MarcusSports\Shared\Domain\ValueObject\DateTimeValueObject;

class ProductCreatedAt extends DateTimeValueObject
{
    public function __construct(DateTime $value)
    {
        parent::__construct($value);
    }
}