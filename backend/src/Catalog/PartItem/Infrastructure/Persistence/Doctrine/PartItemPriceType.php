<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PartItem\Domain\PartItemPrice;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\FloatValueObjectType;

final class PartItemPriceType extends FloatValueObjectType
{
    public static function customTypeName(): string
    {
        return 'part_item_price';
    }

    protected function typeClassName(): string
    {
        return PartItemPrice::class;
    }
}