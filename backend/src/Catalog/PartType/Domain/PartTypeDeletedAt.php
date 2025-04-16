<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Domain;

use DateTimeImmutable;
use MarcusSports\Shared\Domain\ValueObject\NullableDateTimeImmutableValueObject;

class PartTypeDeletedAt extends NullableDateTimeImmutableValueObject
{
    public function __construct(?DateTimeImmutable $value)
    {
        parent::__construct($value);
    }
}