<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Controller;

use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\Filters;
use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsCriteriaFiltersParser;
use MarcusSports\Users\User\Application\SearchByCriteria\UserSearcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCriteriaController
{
    public function __construct(private UserSearcher $searcher)
    {
    }

    public function __invoke(Request $request): Response
    {
        $queryParams = $request->query->all();

        try {
            $paginatedResult = $this->searcher->__invoke($queryParams);
        } catch (\InvalidArgumentException $e) {
            error_log('Search error: ' . $e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            error_log('Search error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Search failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $filters = SearchParamsCriteriaFiltersParser::parse($queryParams);
        } catch (\InvalidArgumentException $e) {
            $filters = new Filters([]);
        }

        $filtersPrimitives = array_map(function (Filter $filter): array {
            return [
                'field' => $filter->field()->value(),
                'operator' => $filter->operator()->value,
                'value' => $filter->value()->value(),
            ];
        }, $filters->filters());

        $users = array_map(function ($user): array {
            return [
                'id' => $user->id()->value(),
                'firstName' => $user->firstName()->value(),
                'lastName' => $user->lastName()->value(),
                'email' => $user->email()->value(),
            ];
        }, $paginatedResult->items());

        return new JsonResponse([
            'data' => $users,
            'meta' => $paginatedResult->meta(),
            'filters' => $filtersPrimitives,
            'orderBy' => $queryParams['orderBy'] ?? null,
            'order' => $queryParams['order'] ?? null,
        ]);
    }
}