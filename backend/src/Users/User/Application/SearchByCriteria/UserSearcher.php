<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Application\SearchByCriteria;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\Criteria\OrderBy;
use MarcusSports\Shared\Domain\Criteria\OrderType;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsCriteriaFiltersParser;
use MarcusSports\Users\User\Domain\Repository\UserRepository;

final readonly class UserSearcher
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(array $queryParams): PaginatedResult
    {
        try {
            $filters = SearchParamsCriteriaFiltersParser::parse($queryParams);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Invalid filter parameters: ' . $e->getMessage());
        }

        $orderBy = $queryParams['orderBy'] ?? null;
        $orderType = $queryParams['order'] ?? null;
        $pageSize = isset($queryParams['pageSize']) ? (int) $queryParams['pageSize'] : null;
        $pageNumber = isset($queryParams['pageNumber']) ? (int) $queryParams['pageNumber'] : null;

        try {
            $order = new Order(
                $orderBy ? new OrderBy($orderBy) : OrderBy::none(),
                $orderType ? OrderType::from($orderType) : OrderType::none()
            );
        } catch (\ValueError $e) {
            throw new \InvalidArgumentException('Invalid order parameters: ' . $e->getMessage());
        }

        try {
            $criteria = new Criteria(
                $filters,
                $order,
                $pageSize > 0 ? $pageSize : null,
                $pageNumber > 0 ? $pageNumber : null
            );
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Invalid pagination parameters: ' . $e->getMessage());
        }

        $result = $this->repository->getByCriteria($criteria);

        return new PaginatedResult(
            $result['items'],
            $result['total'],
            $criteria->pageNumber() ?? 1,
            $criteria->pageSize() ?? 10
        );
    }
}