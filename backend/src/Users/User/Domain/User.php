<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{
    private UserUuid $id;
    private UserFirstName $firstName;
    private UserLastName $lastName;
    private UserEmail $email;
    private UserRole $role;
    private UserPassword $password;
    private UserCreatedAt $createdAt;
    private UserUpdatedAt $updatedAt;
    private ?UserDeletedAt $deletedAt;

    public function __construct(
        UserUuid $id,
        UserFirstName $firstName,
        UserLastName $lastName,
        UserEmail $email,
        UserRole $role,
        UserPassword $password,
        UserCreatedAt $createdAt,
        UserUpdatedAt $updatedAt,
        ?UserDeletedAt $deletedAt
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->role = $role;
    }

    public function id(): UserUuid
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

    public function role(): UserRole
    {
        return $this->role;
    }

    public function createdAt(): UserCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UserUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?UserDeletedAt
    {
        return $this->deletedAt;
    }
}