<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Persistence\Doctrine;

use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\EnumType;
use MarcusSports\Users\User\Domain\UserRole;

final class UserRoleType extends EnumType
{
    public static function customTypeName(): string
    {
        return 'user_role';
    }

    protected function typeClassName(): string
    {
        return UserRole::class;
    }
}