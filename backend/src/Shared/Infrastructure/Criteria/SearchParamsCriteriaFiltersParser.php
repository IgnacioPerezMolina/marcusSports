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
        $tempFilters = [];

        foreach ($queryParams as $key => $value) {
            if (preg_match('/filters\[(\d+)]\[(.+)]/', $key, $matches)) {
                $index = $matches[1];
                $property = $matches[2];

                if (!isset($tempFilters[$index])) {
                    $tempFilters[$index] = [];
                }

                $tempFilters[$index][$property] = $value;
            }
        }

        $filters = array_map(function (array $filterData): Filter {
            if (!isset($filterData['field'], $filterData['operator'], $filterData['value'])) {
                throw new \InvalidArgumentException('Filter must have field, operator, and value');
            }

            return new Filter(
                new FilterField($filterData['field']),
                FilterOperator::from($filterData['operator']),
                new FilterValue($filterData['value'])
            );
        }, array_filter($tempFilters, function (array $filterData): bool {
            return isset($filterData['field'], $filterData['operator'], $filterData['value']);
        }));

        return new Filters($filters);
    }
}