<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Exception;

use RuntimeException;

class DomainException extends RuntimeException
{
    protected int $httpCode = 500;
    protected string $errorCode = 'internal_error';

    public function httpCode(): int
    {
        return $this->httpCode;
    }

    public function errorCode(): string
    {
        return $this->errorCode;
    }
}