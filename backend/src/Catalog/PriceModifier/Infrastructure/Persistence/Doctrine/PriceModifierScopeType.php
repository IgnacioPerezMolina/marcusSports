<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierScope;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\EnumType;

final class PriceModifierScopeType extends EnumType
{
    public static function customTypeName(): string
    {
        return 'price_modifier_scope';
    }

    protected function typeClassName(): string
    {
        return PriceModifierScope::class;
    }
}