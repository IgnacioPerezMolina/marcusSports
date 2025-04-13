<?php

declare(strict_types=1);


namespace MarcusSports\Users\Application\Create;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserCreatedAt;
use MarcusSports\Users\Domain\UserEmail;
use MarcusSports\Users\Domain\UserFirstName;
use MarcusSports\Users\Domain\UserUuid;
use MarcusSports\Users\Domain\UserLastName;
use MarcusSports\Users\Domain\UserPassword;
use MarcusSports\Users\Domain\UserUpdatedAt;
use RuntimeException;

final class UserCreator
{
    public function __invoke(CreateUserRequest $request, UserRepository $repository): void
    {
        $id = new UserUuid($request->id());

        $criteria = Criteria::fromFilters([
            new Filter(
                'email.value',
                FilterOperator::EQUAL,
                strtolower($request->email())
            )
        ],
            limit: 1
        );

        $paginatedResult = $repository->getByCriteria($criteria);

        if ($paginatedResult->total() > 0) {
            throw new \RuntimeException('The email is already in use.');
        }

        if ($repository->find($id)) {
            throw new RuntimeException('Duplicate user');
        }

        $firstName = new UserFirstName($request->firstName());
        $lastName = new UserLastName($request->lastName());
        $email = new UserEmail($request->email());
        $password = new UserPassword($request->password());
        $createdAt = UserCreatedAt::create();
        $updatedAt = UserUpdatedAt::create();
        $deletedAt = null;

        $user = new User(
            $id,
            $firstName,
            $lastName,
            $email,
            $password,
            $createdAt,
            $updatedAt,
            $deletedAt
        );

        $repository->save($user);
    }
}