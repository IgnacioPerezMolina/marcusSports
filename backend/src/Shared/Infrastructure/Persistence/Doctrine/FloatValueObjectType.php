<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use MarcusSports\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;

abstract class FloatValueObjectType extends Type implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column = array_merge(['precision' => 10, 'scale' => 2], $column);
        return $platform->getDecimalTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        if ($value === null || $value === '') {
            return null;
        }
        $className = $this->typeClassName();
        return new $className((float)$value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        $className = $this->typeClassName();
        if ($value instanceof $className) {
            return (string)$value->value();
        }

        return (string)$value;
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