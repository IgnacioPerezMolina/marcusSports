<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use MarcusSports\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'CHAR(36)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        $className = $this->typeClassName();
        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        $className = $this->typeClassName();
        if ($value instanceof $className) {
            return $value->value();
        }

        return $value;
    }

    public function getName(): string
    {
        return static::customTypeName();
    }
}