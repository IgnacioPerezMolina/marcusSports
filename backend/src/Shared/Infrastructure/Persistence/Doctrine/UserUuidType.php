<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use MarcusSports\Users\Domain\UserUuid;

class UserUuidType extends StringType
{
    public const NAME = 'user_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'CHAR(36)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserUuid
    {
        if ($value === null) {
            return null;
        }

        return new UserUuid($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UserUuid) {
            return $value->value();
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}