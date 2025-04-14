<?php

declare(strict_types=1);

namespace MarcusSports\Users\Auth\Infrastructure\Provider;

use MarcusSports\Users\Auth\Domain\BearerUser;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\UserEmail;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class BearerUserProvider implements UserProviderInterface
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->repository->findByEmail(new UserEmail($identifier));
        if (!$user) {
            throw new UserNotFoundException(sprintf('User with id "%s" not found', $identifier));
        }

        // Aquí puedes asignar roles de forma fija o consultarlos según la lógica de tu dominio.
        $roles = ['ROLE_USER'];
        return new BearerUser($user, $roles);
    }

    // Para compatibilidad con Symfony < 5.3:
    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof BearerUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === BearerUser::class || is_subclass_of($class, BearerUser::class);
    }
}
