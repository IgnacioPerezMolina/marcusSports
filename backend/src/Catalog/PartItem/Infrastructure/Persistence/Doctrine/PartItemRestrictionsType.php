<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PartItem\Domain\PartItemRestrictions;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\JsonStringValueObjectType;

class PartItemRestrictionsType extends JsonStringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'part_item_restrictions';
    }

    protected function typeClassName(): string
    {
        return PartItemRestrictions::class;
    }

}