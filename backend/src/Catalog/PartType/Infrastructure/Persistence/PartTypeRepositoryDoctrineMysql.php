<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Infrastructure\Persistence;

use MarcusSports\Catalog\PartType\Domain\PartType;
use MarcusSports\Catalog\PartType\Domain\Repository\PartTypeRepository;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class PartTypeRepositoryDoctrineMysql extends DoctrineRepository implements PartTypeRepository
{
    public function save(PartType $partType): void
    {
        $this->persist($partType);
    }

    public function findAll(): array
    {
        return $this->repository(PartType::class)->findAll();
    }
}