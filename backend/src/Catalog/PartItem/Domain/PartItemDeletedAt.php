<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Domain;

use DateTimeImmutable;
use MarcusSports\Shared\Domain\ValueObject\NullableDateTimeImmutableValueObject;

class PartItemDeletedAt extends NullableDateTimeImmutableValueObject
{
    public function __construct(?DateTimeImmutable $value)
    {
        parent::__construct($value);
    }
}