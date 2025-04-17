<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\ValueObject\JsonStringValueObject;

final class PartItemRestrictions extends JsonStringValueObject
{
    protected function validate(array $value): void
    {
//        if (!isset($value['if']) || !isset($value['then'])) {
//            throw new InvalidArgumentException('The restrictions must include "if" and "then" keys.');
//        }
    }
}
