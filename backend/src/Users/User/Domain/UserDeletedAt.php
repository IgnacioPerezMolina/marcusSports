<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Domain;

use DateTimeImmutable;
use MarcusSports\Shared\Domain\ValueObject\NullableDateTimeImmutableValueObject;

class UserDeletedAt extends NullableDateTimeImmutableValueObject
{
    public function __construct(?DateTimeImmutable $value)
    {
        parent::__construct($value);
    }
}