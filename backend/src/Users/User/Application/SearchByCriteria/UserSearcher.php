<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Application\SearchByCriteria;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsToCriteriaConverter;
use MarcusSports\Users\User\Domain\Repository\UserRepository;

final readonly class UserSearcher
{
    public function __construct(
        private UserRepository $repository,
        private SearchParamsToCriteriaConverter $criteriaConverter
    ) {
    }

    public function __invoke(array $queryParams): UsersSearchResponse
    {
        try {
            $criteria = $this->criteriaConverter->convert($queryParams);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Invalid search parameters: ' . $e->getMessage());
        }

        $result = $this->repository->getByCriteria($criteria);

        $filtersPrimitives = array_map(function (Filter $filter): array {
            return [
                'field' => $filter->field()->value(),
                'operator' => $filter->operator()->value,
                'value' => $filter->value()->value(),
            ];
        }, $criteria->filters()->filters());

        $paginatedResult = new PaginatedResult(
            $result['items'],
            $result['total'],
            $criteria->pageNumber() ?? 1,
            $criteria->pageSize() ?? 10
        );

        return new UsersSearchResponse(
            $paginatedResult,
            $filtersPrimitives,
            $queryParams['orderBy'] ?? null,
            $queryParams['order'] ?? null
        );
    }
}