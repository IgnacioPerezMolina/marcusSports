<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidArgumentException extends DomainException
{
    public function __construct(string $message = "Invalid argument")
    {
        $this->httpCode = Response::HTTP_BAD_REQUEST;
        parent::__construct($message, $this->httpCode);
    }
}