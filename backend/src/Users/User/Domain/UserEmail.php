<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\ValueObject\EmailValueObject;

final class UserEmail extends EmailValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}