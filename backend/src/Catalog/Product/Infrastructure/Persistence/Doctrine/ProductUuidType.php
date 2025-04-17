<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\Product\Domain\ProductUuid;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ProductUuidType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'product_uuid';
    }

    protected function typeClassName(): string
    {
        return ProductUuid::class;
    }
}