<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PartItem\Domain\PartItemAttributes;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\JsonStringValueObjectType;

class PartItemAttributesType extends JsonStringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'part_item_attributes';
    }

    protected function typeClassName(): string
    {
        return PartItemAttributes::class;
    }

}