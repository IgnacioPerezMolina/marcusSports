<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Shared\Domain\ValueObject\Uuid;

final class PartItemUuid extends Uuid
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}