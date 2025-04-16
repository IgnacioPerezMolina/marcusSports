<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Domain;

use DateTime;
use MarcusSports\Shared\Domain\ValueObject\DateTimeValueObject;

class PartItemCreatedAt extends DateTimeValueObject
{
    public function __construct(DateTime $value)
    {
        parent::__construct($value);
    }
}