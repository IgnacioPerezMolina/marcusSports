<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Application\Create;

use MarcusSports\Catalog\Product\Domain\Product;
use MarcusSports\Catalog\Product\Domain\ProductBasePrice;
use MarcusSports\Catalog\Product\Domain\ProductCategory;
use MarcusSports\Catalog\Product\Domain\ProductCreatedAt;
use MarcusSports\Catalog\Product\Domain\ProductDescription;
use MarcusSports\Catalog\Product\Domain\ProductName;
use MarcusSports\Catalog\Product\Domain\ProductUpdatedAt;
use MarcusSports\Catalog\Product\Domain\ProductUuid;
use MarcusSports\Catalog\Product\Domain\Repository\ProductRepository;

final class ProductCreator
{
    public function __invoke(CreateProductRequest $request, ProductRepository $repository)
    {
        $id = new ProductUuid($request->id());
        $name = new ProductName($request->name());
        $description = new ProductDescription($request->description());
        $category = ProductCategory::from($request->category());
        $basePrice = new ProductBasePrice($request->basePrice());
        $createdAt = ProductCreatedAt::create();
        $updatedAt = ProductUpdatedAt::create();
        $deletedAt = null;

        $product = new Product(
            $id,
            $name,
            $description,
            $category,
            $basePrice,
            null,
            null,
            null,
            $createdAt,
            $updatedAt,
            $deletedAt
        );

        $repository->save($product);
    }
}