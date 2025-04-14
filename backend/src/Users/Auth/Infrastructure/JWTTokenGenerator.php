<?php

declare(strict_types=1);

namespace MarcusSports\Users\Auth\Infrastructure;

use MarcusSports\Users\Auth\Domain\TokenGeneratorInterface;
use MarcusSports\Users\User\Domain\User;

final class JWTTokenGenerator implements TokenGeneratorInterface
{
    private string $secretKey;
    private string $algorithm;

    public function __construct(string $secretKey, string $algorithm = 'HS256')
    {
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    public function generateAccessToken(User $user): string
    {
        $payload = [
            'sub' => $user->id()->value(),
            'roles' => $user->roles(),
            'iat' => time(),
            'exp' => time() + 3600,
        ];
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    public function generateRefreshToken(User $user): string
    {
        $payload = [
            'sub' => $user->id()->value(),
            'iat' => time(),
            'exp' => time() + 3600 * 24 * 7,
        ];
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }
}
