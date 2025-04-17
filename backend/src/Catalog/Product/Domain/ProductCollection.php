<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Domain;

class ProductCollection
{
    /** @var Product[] */
    private array $products;

    public function __construct(array $products = [])
    {
        $this->products = array_filter($products, fn($item) => $item instanceof Product);
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    /** @return Product[] */
    public function all(): array
    {
        return $this->products;
    }

    public function toArray(): array
    {
        return array_map(fn(Product $product) => $product->toArray(), $this->products);
    }
}