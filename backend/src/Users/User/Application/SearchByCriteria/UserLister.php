<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Application\SearchByCriteria;

use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\UserCriteria;

readonly class UserLister
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(?array $filters = null, ?Order $order = null, ?int $offset = null, ?int $limit = null): PaginatedResult
    {
        $criteria = UserCriteria::fromFilters($filters, $order, $offset, $limit);
        return $this->repository->getByCriteria($criteria);
    }
}