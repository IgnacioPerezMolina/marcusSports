<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\QueryBuilder;
use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\CriteriaTransformer;

final class DoctrineCriteriaTransformer implements CriteriaTransformer
{
    private array $fieldMappings;

    public function __construct(array $fieldMappings = [])
    {
        $this->fieldMappings = $fieldMappings;
    }

    public function transform(Criteria $criteria, mixed $context, string $alias): QueryBuilder
    {
        if (!$context instanceof QueryBuilder) {
            throw new \InvalidArgumentException('Context must be a QueryBuilder');
        }

        $this->applyFilters($context, $criteria, $alias);
        $this->applyOrder($context, $criteria, $alias);
        $this->applyPagination($context, $criteria);

        return $context;
    }

    private function applyFilters(QueryBuilder $queryBuilder, Criteria $criteria, string $alias): void
    {
        foreach ($criteria->filters()->filters() as $index => $filter) {
            $field = $filter->field()->value();
            $operator = $filter->operator()->value;
            $value = $filter->value()->value();
            $paramName = "param_{$index}";

            $mappedField = $this->fieldMappings[$field] ?? $field;

            switch ($operator) {
                case '=':
                    $queryBuilder->andWhere(sprintf('%s.%s = :%s', $alias, $mappedField, $paramName));
                    break;
                case 'CONTAINS':
                    $queryBuilder->andWhere(sprintf('%s.%s LIKE :%s', $alias, $mappedField, $paramName));
                    $value = "%{$value}%";
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported operator: {$operator}");
            }

            $queryBuilder->setParameter($paramName, $value);
        }
    }

    private function applyOrder(QueryBuilder $queryBuilder, Criteria $criteria, string $alias): void
    {
        if ($criteria->hasOrder()) {
            $orderBy = $criteria->order()->orderBy()->value();
            $orderType = strtolower($criteria->order()->orderType()->value);

            $mappedOrderBy = $this->fieldMappings[$orderBy] ?? $orderBy;
            $queryBuilder->orderBy(sprintf('%s.%s', $alias, $mappedOrderBy), $orderType);
        }
    }

    private function applyPagination(QueryBuilder $queryBuilder, Criteria $criteria): void
    {
        if ($criteria->hasPagination()) {
            $queryBuilder->setMaxResults($criteria->pageSize());
            $queryBuilder->setFirstResult(($criteria->pageNumber() - 1) * $criteria->pageSize());
        }
    }
}