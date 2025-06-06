<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Doctrine\Dbal;

use Doctrine\DBAL\Types\Type;
use function Lambdish\Phunctional\each;

final class DbalCustomTypesRegistrar
{
    private static bool $initialized = false;

    public static function register(array $customTypeClassNames): void
    {
        if (!self::$initialized) {
            foreach ($customTypeClassNames as $customTypeClassName) {
                Type::addType($customTypeClassName::customTypeName(), $customTypeClassName);
            }

            self::$initialized = true;
        }
    }

    private static function registerType(): callable
    {
        return static function (string $customTypeClassName): void {
            Type::addType($customTypeClassName::customTypeName(), $customTypeClassName);
        };
    }
}
