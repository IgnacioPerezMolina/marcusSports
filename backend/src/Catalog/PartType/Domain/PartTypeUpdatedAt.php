<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Domain;

use DateTime;
use MarcusSports\Shared\Domain\ValueObject\DateTimeValueObject;

class PartTypeUpdatedAt extends DateTimeValueObject
{
    public function __construct(DateTime $value)
    {
        parent::__construct($value);
    }
}