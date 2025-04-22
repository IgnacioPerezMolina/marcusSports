<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Application\SearchByCriteria;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Users\User\Domain\Repository\UserRepository;

final readonly class UserSearcher
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(Criteria $criteria): array
    {
        return $this->repository->getByCriteria($criteria);
    }
}