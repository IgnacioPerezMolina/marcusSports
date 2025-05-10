<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Criteria;

use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\FilterField;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\Criteria\FilterValue;
use MarcusSports\Shared\Domain\Criteria\Filters;

final class SearchParamsCriteriaFiltersParser
{
    public static function parse(array $queryParams): Filters
    {
        $filtersData = $queryParams['filters'] ?? [];

        $filters = array_map(function (array $filterData): Filter {
            if (!isset($filterData['field'], $filterData['operator'], $filterData['value'])) {
                throw new \InvalidArgumentException('Filter must have field, operator, and value');
            }

            try {
                $operator = FilterOperator::{$filterData['operator']};
            } catch (\Error) {
                throw new \InvalidArgumentException("Invalid operator: {$filterData['operator']}");
            }

            return new Filter(
                new FilterField($filterData['field']),
                $operator,
                new FilterValue($filterData['value'])
            );
        }, array_filter($filtersData, function (array $filterData): bool {
            return isset($filterData['field'], $filterData['operator'], $filterData['value']);
        }));

        return new Filters($filters);
    }
}