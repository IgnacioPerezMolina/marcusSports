<?php

declare(strict_types=1);


namespace MarcusSports\Users\Domain;

use DateTimeImmutable;
use MarcusSports\Shared\Domain\ValueObject\DateTimeImmutableValueObject;

class UserDeletedAt extends DateTimeImmutableValueObject
{
    public function __construct(DateTimeImmutable $value)
    {
        parent::__construct($value);
    }
}