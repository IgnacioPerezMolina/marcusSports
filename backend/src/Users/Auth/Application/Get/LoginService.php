<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Application\Get;

use RuntimeException;
use MarcusSports\Users\Auth\Domain\AuthSession;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserPassword;

class LoginService
{
    public function __invoke(GetTokenRequest $request, UserRepository $repository): AuthSession
    {
        $email = new UserEmail($request->email());
        $password = new UserPassword($request->password());

        $user = $repository->findByEmail($email);
        if (!$user) {
            throw new RuntimeException('Usuario no encontrado');
        }

        if (!$password->verify($password->value(), $user->passwordHash())) {
            throw new RuntimeException('Contraseña incorrecta');
        }

        $accessToken = $this->tokenGenerator->generateAccessToken($user);
        $refreshToken = $this->tokenGenerator->generateRefreshToken($user);

        $createdAt = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        $expiresAt = (new \DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s');

        $authSession = new AuthSession(
            $user->id(),
            $accessToken,
            $refreshToken,
            $expiresAt,
            $createdAt,
            'active'
        );

        return $authSession;
    }
}