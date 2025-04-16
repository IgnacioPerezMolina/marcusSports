<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Domain\Repository;

interface PartTypeRepository
{
    public function save(): void;
}