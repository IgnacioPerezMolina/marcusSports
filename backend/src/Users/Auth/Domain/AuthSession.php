<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Domain;

use MarcusSports\Users\User\Domain\UserUuid;

class AuthSession
{
    private UserUuid $userId;
    private string $accessToken;
    private string $refreshToken;
    private string $expiresAt;
    private string $createdAt;
    private string $status;

    public function __construct(
        UserUuid $userId,
        string $accessToken,
        string $refreshToken,
        string $expiresAt,
        string $createdAt,
        string $status
    )
    {
        $this->userId = $userId;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expiresAt = $expiresAt;
        $this->createdAt = $createdAt;
        $this->status = $status;
    }

    public function userId(): UserUuid
    {
        return $this->userId;
    }

    public function accessToken(): string
    {
        return $this->accessToken;
    }

    public function refreshToken(): string
    {
        return $this->refreshToken;
    }

    public function expiresAt(): string
    {
        return $this->expiresAt;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function status(): string
    {
        return $this->status;
    }
}