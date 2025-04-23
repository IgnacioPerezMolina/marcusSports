<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Criteria;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\InvalidCriteria;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\Criteria\OrderBy;
use MarcusSports\Shared\Domain\Criteria\OrderType;

final class SearchParamsToCriteriaConverter
{
    public function __construct(private SearchParamsCriteriaFiltersParser $parser)
    {
    }

    /**
     * @throws InvalidCriteria
     */
    public function convert(array $queryParams): Criteria
    {
        $filters = $this->parser->parse($queryParams);
        $orderBy = $queryParams['orderBy'] ?? null;
        $orderType = $queryParams['order'] ?? null;

        $order = ($orderBy || $orderType)
            ? new Order(
                $orderBy ? new OrderBy($orderBy) : new OrderBy('id'),
                $orderType ? OrderType::from($orderType) : OrderType::ASC
            )
            : Order::none();

        return new Criteria(
            $filters,
            $order,
            isset($queryParams['pageSize']) && (int) $queryParams['pageSize'] > 0 ? (int) $queryParams['pageSize'] : null,
            isset($queryParams['pageNumber']) && (int) $queryParams['pageNumber'] > 0 ? (int) $queryParams['pageNumber'] : null
        );
    }
}