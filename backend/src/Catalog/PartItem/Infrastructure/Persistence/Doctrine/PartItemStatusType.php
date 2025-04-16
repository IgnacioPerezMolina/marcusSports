<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PartItem\Domain\PartItemStatus;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\EnumType;

final class PartItemStatusType extends EnumType
{
    public static function customTypeName(): string
    {
        return 'part_item_status';
    }

    protected function typeClassName(): string
    {
        return PartItemStatus::class;
    }
}