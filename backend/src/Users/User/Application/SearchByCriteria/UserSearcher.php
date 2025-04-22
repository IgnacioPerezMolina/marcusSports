<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Application\SearchByCriteria;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
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

    public function __invoke(array $queryParams): UsersSearchResponse
    {
        try {
            $filters = SearchParamsCriteriaFiltersParser::parse($queryParams);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Invalid filter parameters: ' . $e->getMessage());
        }

        $orderBy = $queryParams['orderBy'] ?? null;
        $orderType = $queryParams['order'] ?? null;

        try {
            $order = ($orderBy || $orderType)
                ? new Order(
                    $orderBy ? new OrderBy($orderBy) : new OrderBy('id'),
                    $orderType ? OrderType::from($orderType) : OrderType::ASC
                )
                : Order::none();
        } catch (\ValueError $e) {
            throw new \InvalidArgumentException('Invalid order parameters: ' . $e->getMessage());
        }

        try {
            $criteria = new Criteria(
                $filters,
                $order,
                isset($queryParams['pageSize']) && (int) $queryParams['pageSize'] > 0 ? (int) $queryParams['pageSize'] : null,
                isset($queryParams['pageNumber']) && (int) $queryParams['pageNumber'] > 0 ? (int) $queryParams['pageNumber'] : null
            );
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Invalid pagination parameters: ' . $e->getMessage());
        }

        $result = $this->repository->getByCriteria($criteria);

        $filtersPrimitives = array_map(function (Filter $filter): array {
            return [
                'field' => $filter->field()->value(),
                'operator' => $filter->operator()->value,
                'value' => $filter->value()->value(),
            ];
        }, $filters->filters());

        $paginatedResult = new PaginatedResult(
            $result['items'],
            $result['total'],
            $criteria->pageNumber() ?? 1,
            $criteria->pageSize() ?? 10
        );

        return new UsersSearchResponse($paginatedResult, $filtersPrimitives, $orderBy, $orderType);
    }
}