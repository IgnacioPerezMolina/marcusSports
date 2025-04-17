<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierUuid;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class PriceModifierUuidType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'price_modifier_uuid';
    }

    protected function typeClassName(): string
    {
        return PriceModifierUuid::class;
    }
}