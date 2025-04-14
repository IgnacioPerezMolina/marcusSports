<?php

declare(strict_types=1);

namespace MarcusSports\Users\Auth\Application\Get;

use MarcusSports\Users\Auth\Domain\BearerUser;
use MarcusSports\Users\Auth\Domain\TokenGeneratorInterface;
use RuntimeException;
use MarcusSports\Users\Auth\Domain\AuthSession;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use MarcusSports\Users\User\Domain\UserEmail;

class LoginService
{
    public function __invoke(GetTokenRequest $request, UserRepository $repository, TokenGeneratorInterface $tokenGenerator): AuthSession
    {
        $email = new UserEmail($request->email());

        $user = $repository->findByEmail($email);
        if (!$user) {
            throw new RuntimeException('User not found');
        }

        if (!$user->password()->verify($request->password())) {
            throw new RuntimeException('Wrong password');
        }

        $roles = ['ROLE_USER'];
        $securityUser = new BearerUser($user, $roles);

        $accessToken = $tokenGenerator->generateAccessToken($securityUser);
        $refreshToken = $tokenGenerator->generateRefreshToken($securityUser);

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

        // TODO add domain Event

        return $authSession;
    }
}