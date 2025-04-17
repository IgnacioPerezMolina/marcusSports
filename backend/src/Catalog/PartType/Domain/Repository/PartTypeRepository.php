<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Domain\Repository;

use MarcusSports\Catalog\PartType\Domain\PartType;

interface PartTypeRepository
{
    public function save(PartType $partType): void;

    public function findAll(): array;
}