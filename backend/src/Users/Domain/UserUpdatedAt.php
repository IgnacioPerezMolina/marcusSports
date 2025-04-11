<?php

declare(strict_types=1);


namespace MarcusSports\Users\Domain;

use DateTime;
use MarcusSports\Shared\Domain\ValueObject\DateTimeValueObject;

class UserUpdatedAt extends DateTimeValueObject
{
    public function __construct(DateTime $value)
    {
        parent::__construct($value);
    }
}