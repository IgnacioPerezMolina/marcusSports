<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Controller;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\Criteria\OrderBy;
use MarcusSports\Shared\Domain\Criteria\OrderType;
use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsCriteriaFiltersParser;
use MarcusSports\Users\User\Application\SearchByCriteria\UserSearcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCriteriaController
{
    private UserSearcher $searcher;

    public function __construct(UserSearcher $searcher)
    {
        $this->searcher = $searcher;
    }

    public function __invoke(Request $request): Response
    {
        $queryParams = $request->query->all();
//        error_log('Query params: ' . print_r($queryParams, true));

        try {
            $filters = SearchParamsCriteriaFiltersParser::parse($queryParams);
        } catch (\InvalidArgumentException $e) {
            error_log('Filter parsing error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid filter parameters'], Response::HTTP_BAD_REQUEST);
        }

        $orderBy = $request->query->get('orderBy');
        $orderType = $request->query->get('order');

        try {
            $order = new Order(
                $orderBy ? new OrderBy($orderBy) : OrderBy::none(),
                $orderType ? OrderType::from($orderType) : OrderType::none()
            );
        } catch (\ValueError $e) {
            error_log('Order creation error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid order parameters'], Response::HTTP_BAD_REQUEST);
        }

        $criteria = new Criteria($filters, $order, null, null);

        try {
            $users = $this->searcher->__invoke($criteria);
        } catch (\Exception $e) {
            error_log('Search error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Search failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $filtersPrimitives = array_map(function (Filter $filter): array {
            return [
                'field' => $filter->field()->value(),
                'operator' => $filter->operator()->value,
                'value' => $filter->value()->value(),
            ];
        }, $filters->filters());

        return new JsonResponse([
            'filters' => $filtersPrimitives,
            'orderBy' => $orderBy,
            'order' => $orderType,
            'users' => array_map(function ($user): array {
                return [
                    'id' => $user->id()->value(),
                    'firstName' => $user->firstName()->value(),
                    'lastName' => $user->lastName()->value(),
                    'email' => $user->email()->value(),
                ];
            }, $users),
        ]);
    }
}