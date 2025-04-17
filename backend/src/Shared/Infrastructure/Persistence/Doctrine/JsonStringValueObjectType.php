<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use MarcusSports\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;

abstract class JsonStringValueObjectType extends JsonType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
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
            return (string) $value;
        }

        return $value;
    }

    public function getName(): string
    {
        return static::customTypeName();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}