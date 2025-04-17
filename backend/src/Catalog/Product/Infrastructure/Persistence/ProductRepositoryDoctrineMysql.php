<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Infrastructure\Persistence;

use MarcusSports\Catalog\Product\Domain\Product;
use MarcusSports\Catalog\Product\Domain\ProductUuid;
use MarcusSports\Catalog\Product\Domain\Repository\ProductRepository;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class ProductRepositoryDoctrineMysql extends DoctrineRepository implements ProductRepository
{
    public function save(Product $product): void
    {
        $this->persist($product);
    }

    public function find(ProductUuid $uuid): ?Product
    {
        return $this->repository(Product::class)->find($uuid);
    }

    public function findAll(): array
    {
        return $this->repository(Product::class)
            ->createQueryBuilder('p')
            ->select('p', 'pt')
            ->leftJoin('p.partTypes', 'pt')
            ->where('p.deletedAt.value IS NULL')
            ->getQuery()
            ->getResult();
    }
}