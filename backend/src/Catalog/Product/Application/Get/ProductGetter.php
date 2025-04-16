<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Application\Get;

use MarcusSports\Catalog\Product\Domain\ProductCollection;
use MarcusSports\Catalog\Product\Domain\Repository\ProductRepository;

final class ProductGetter
{
    public function __invoke(GetProductsRequest $request, ProductRepository $repository)
    {
        $products = $repository->findAll();
        return (new ProductCollection($products))->toArray();
    }
}