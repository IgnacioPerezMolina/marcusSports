<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Infrastructure\Persistence\Doctrine;

use MarcusSports\Catalog\PartType\Domain\PartTypeUuid;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class PartTypeUuidType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'part_type_uuid';
    }

    protected function typeClassName(): string
    {
        return PartTypeUuid::class;
    }
}