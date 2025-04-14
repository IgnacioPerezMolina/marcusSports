<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Persistence\Doctrine;

use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\UuidType;
use MarcusSports\Users\User\Domain\UserUuid;

final class UserUuidType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'user_uuid';
    }

    protected function typeClassName(): string
    {
        return UserUuid::class;
    }
}