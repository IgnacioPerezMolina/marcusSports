<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Controller;

use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\Criteria\OrderType;
use MarcusSports\Users\User\Application\SearchByCriteria\UserLister;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\UserCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListUserGetController
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(Request $request, ?string $firstName, ?string $lastName, ?string $role): JsonResponse
    {
        if ($firstName !== null) {
            $filters[] = new Filter('firstName.value', FilterOperator::CONTAINS, $firstName);
        }

        if ($lastName !== null) {
            $filters[] = new Filter('lastName.value', FilterOperator::CONTAINS, $lastName);
        }

        if ($role !== null) {
            $filters[] = new Filter('role.value', FilterOperator::CONTAINS, $role);
        }

        $result = (new UserLister($this->repository))(
          $filters ?? [],
          new Order('firstName.value', OrderType::ASC),
          0,
          5
        );

//        dd($result->items()->toArray());

        return new JsonResponse($result->items()->toArray());
    }
}