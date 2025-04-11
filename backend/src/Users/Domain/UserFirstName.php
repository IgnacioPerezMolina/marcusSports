<?php

declare(strict_types=1);

namespace MarcusSports\Users\Domain;

use MarcusSports\Shared\Domain\ValueObject\StringValueObject;

final class UserFirstName extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}