<?php

declare(strict_types=1);


namespace MarcusSports\Users\Application\Create;

final class CreateUserRequest
{
    private string $uuid;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;

    public function __construct(string $uuid, string $firstName, string $lastName, string $email, string $password)
    {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}