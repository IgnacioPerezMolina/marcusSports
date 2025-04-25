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
    public function __construct(
        private SearchParamsCriteriaFiltersParser $filtersParser
    ) {
    }

    public function convert(
        array $filters,
        ?string $orderBy,
        ?string $order,
        ?int $pageSize,
        ?int $pageNumber
    ): Criteria {
        $filters = $this->filtersParser->parse(['filters' => $filters]);
        $order = Order::fromPrimitives($orderBy, $order);
        return new Criteria($filters, $order, $pageSize, $pageNumber);
    }
}