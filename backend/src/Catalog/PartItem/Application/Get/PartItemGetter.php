<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Application\Get;

use MarcusSports\Catalog\PartItem\Domain\PartItemCollection;
use MarcusSports\Catalog\PartItem\Domain\Repository\PartItemRepository;

class PartItemGetter
{
    public function __invoke(GetPartItemRequest $request, PartItemRepository $repository): array
    {
        $partTypes = $repository->findAll();
        return (new PartItemCollection($partTypes))->toArray();
    }
}