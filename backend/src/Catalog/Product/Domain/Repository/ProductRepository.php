<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Domain\Repository;

use MarcusSports\Catalog\Product\Domain\Product;
use MarcusSports\Catalog\Product\Domain\ProductUuid;

interface ProductRepository
{
    public function save(Product $product): void;
    public function find(ProductUuid $uuid): ?Product;

    public function findAll(): array;
}