<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PartItem\Domain\PartItemUuid;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class PartItemUuidType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'part_item_uuid';
    }

    protected function typeClassName(): string
    {
        return PartItemUuid::class;
    }
}