<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MarcusSports\Shared\Domain\Aggregate\AggregateEntity;

abstract class DoctrineRepository
{

    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(AggregateEntity $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    protected function remove(AggregateEntity $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }
}