<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\CompatibilityRule\Infrastructure\Persistence;

use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRule;
use MarcusSports\Catalog\CompatibilityRule\Domain\Repository\CompatibilityRuleRepository;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class CompatibilityRuleRepositoryDoctrineMysql extends DoctrineRepository implements CompatibilityRuleRepository
{
    public function save(CompatibilityRule $compatibilityRule): void
    {
        $this->persist($compatibilityRule);
    }

    public function findAll(): array
    {
        return $this->repository(CompatibilityRule::class)->findAll();
    }
}