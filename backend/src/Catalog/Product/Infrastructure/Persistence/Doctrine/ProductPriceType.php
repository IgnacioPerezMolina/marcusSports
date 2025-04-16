<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\Product\Domain\ProductBasePrice;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\FloatValueObjectType;

final class ProductPriceType extends FloatValueObjectType
{
    public static function customTypeName(): string
    {
        return 'product_base_price';
    }

    protected function typeClassName(): string
    {
        return ProductBasePrice::class;
    }
}