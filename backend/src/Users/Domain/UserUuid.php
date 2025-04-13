<?php

declare(strict_types=1);

namespace MarcusSports\Users\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

final class UserUuid extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}