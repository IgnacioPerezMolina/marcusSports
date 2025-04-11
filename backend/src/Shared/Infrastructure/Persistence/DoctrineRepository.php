<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;

abstract class DoctrineRepository
{

    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }
}