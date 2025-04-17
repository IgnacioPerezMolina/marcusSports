<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\Product\Domain\ProductCategory;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\EnumType;

final class ProductCategoryType extends EnumType
{
    public static function customTypeName(): string
    {
        return 'product_category';
    }

    protected function typeClassName(): string
    {
        return ProductCategory::class;
    }
}