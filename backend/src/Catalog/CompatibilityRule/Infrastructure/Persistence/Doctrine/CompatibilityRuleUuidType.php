<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRuleUuid;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class CompatibilityRuleUuidType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'compatibility_rule_uuid';
    }

    protected function typeClassName(): string
    {
        return CompatibilityRuleUuid::class;
    }
}