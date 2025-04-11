<?php

declare(strict_types=1);

namespace MarcusSports\Users\Domain;

use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{
    private UserId $id;
    private UserFirstName $firstName;
    private UserLastName $lastName;
    private UserEmail $email;
    private UserPassword $password;
    private UserCreatedAt $createdAt;
    private UserUpdatedAt $updatedAt;
    private ?UserDeletedAt $deletedAt;

    public function __construct(
        UserId $id,
        UserFirstName $firstName,
        UserLastName $lastName,
        UserEmail $email,
        UserPassword $password,
        UserCreatedAt $createdAt,
        UserUpdatedAt $updatedAt,
        ?UserDeletedAt $deletedAt
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function firstName(): UserFirstName
    {
        return $this->firstName;
    }

    public function lastName(): UserLastName
    {
        return $this->lastName;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function createdAt(): UserCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UserUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): UserDeletedAt
    {
        return $this->deletedAt;
    }
}