<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Domain;

use MarcusSports\Users\User\Domain\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BearerUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private User $user;
    private array $roles;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->roles = [strtoupper($this->user->role()->value)];
    }
    public function getUserIdentifier(): string
    {
        return $this->user->id()->value();
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return $this->user->password()->value();
    }

    public function eraseCredentials(): void
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

}