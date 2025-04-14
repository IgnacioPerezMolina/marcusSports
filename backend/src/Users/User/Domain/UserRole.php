<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;
use MarcusSports\Shared\Domain\Enum\Valuable;

enum UserRole: string implements Valuable
{
    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';
    case USER = 'user';

    public function value(): string
    {
        return $this->value;
    }
}