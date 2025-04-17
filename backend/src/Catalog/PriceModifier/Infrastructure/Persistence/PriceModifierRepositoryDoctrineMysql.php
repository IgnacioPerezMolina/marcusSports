<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Infrastructure\Persistence;

use MarcusSports\Catalog\PriceModifier\Domain\PriceModifier;
use MarcusSports\Catalog\PriceModifier\Domain\Repository\PriceModifierRepository;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class PriceModifierRepositoryDoctrineMysql extends DoctrineRepository implements PriceModifierRepository
{
    public function save(PriceModifier $priceModifier): void
    {
        $this->persist($priceModifier);
    }

    public function findAll(): array
    {
        return $this->repository(PriceModifier::class)->findAll();
    }
}