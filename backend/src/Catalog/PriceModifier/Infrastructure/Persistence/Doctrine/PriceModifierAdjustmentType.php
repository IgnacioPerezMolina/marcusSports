<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierAdjustment;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\FloatValueObjectType;

final class PriceModifierAdjustmentType extends FloatValueObjectType
{
    public static function customTypeName(): string
    {
        return 'price_modifier_adjustment';
    }

    protected function typeClassName(): string
    {
        return PriceModifierAdjustment::class;
    }
}