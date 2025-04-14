<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Application\Create;

use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserCreatedAt;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserFirstName;
use MarcusSports\Users\User\Domain\UserLastName;
use MarcusSports\Users\User\Domain\UserPassword;
use MarcusSports\Users\User\Domain\UserRole;
use MarcusSports\Users\User\Domain\UserUpdatedAt;
use MarcusSports\Users\User\Domain\UserUuid;
use RuntimeException;

final class UserCreator
{
    public function __invoke(CreateUserRequest $request, UserRepository $repository): void
    {
        $id = new UserUuid($request->id());

        // TODO Maybe I need to use another case of use to check this
        $existentUser = $repository->findByEmail(new UserEmail($request->email()));

        if ($existentUser !== null) {
            throw new RuntimeException('The email is already in use.');
        }

        if ($repository->find($id)) {
            throw new RuntimeException('Duplicate user');
        }

        $firstName = new UserFirstName($request->firstName());
        $lastName = new UserLastName($request->lastName());
        $email = new UserEmail($request->email());
        $password = UserPassword::fromPlain($request->password());
        $role = UserRole::USER;
        $createdAt = UserCreatedAt::create();
        $updatedAt = UserUpdatedAt::create();
        $deletedAt = null;

        $user = new User(
            $id,
            $firstName,
            $lastName,
            $email,
            $role,
            $password,
            $createdAt,
            $updatedAt,
            $deletedAt
        );

        $repository->save($user);
    }
}