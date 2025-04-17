<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\ValueObject\JsonStringValueObject;

final class PartItemAttributes extends JsonStringValueObject
{
    protected function validate(array $value): void
    {
//        if (empty($value)) {
//            throw new InvalidArgumentException('Part item attributes cannot be empty.');
//        }
    }
}
