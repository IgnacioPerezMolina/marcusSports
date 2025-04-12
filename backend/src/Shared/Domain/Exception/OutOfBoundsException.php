<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class OutOfBoundsException extends InvalidArgumentException
{
    public function __construct(string $message = "Out of Bounds argument")
    {
        $this->httpCode = Response::HTTP_BAD_REQUEST;
        $this->errorCode = "out_of_bounds";
        parent::__construct($message);
    }
}