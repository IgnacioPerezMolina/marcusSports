<?php

declare(strict_types=1);


namespace MarcusSports\Users\Application\Create;

use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\UserCreatedAt;
use MarcusSports\Users\Domain\UserEmail;
use MarcusSports\Users\Domain\UserFirstName;
use MarcusSports\Users\Domain\UserId;
use MarcusSports\Users\Domain\UserLastName;
use MarcusSports\Users\Domain\UserPassword;
use MarcusSports\Users\Domain\UserUpdatedAt;

final class UserCreator
{
    public function __invoke(CreateUserRequest $request, UserRepository $repository): void
    {
        $id = new UserId($request->id());
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