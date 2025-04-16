<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Domain\Repository;

use MarcusSports\Catalog\PartItem\Domain\PartItem;

interface PartItemRepository
{
    public function save(PartItem $partItem): void;
}