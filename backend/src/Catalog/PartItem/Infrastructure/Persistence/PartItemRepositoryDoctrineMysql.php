<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Infrastructure\Persistence;

use MarcusSports\Catalog\PartItem\Domain\PartItem;
use MarcusSports\Catalog\PartItem\Domain\Repository\PartItemRepository;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class PartItemRepositoryDoctrineMysql extends DoctrineRepository implements PartItemRepository
{
    public function save(PartItem $partItem): void
    {
        $this->persist($partItem);
    }

    public function findAll(): array
    {
        return $this->repository(PartItem::class)->findAll();
    }
}