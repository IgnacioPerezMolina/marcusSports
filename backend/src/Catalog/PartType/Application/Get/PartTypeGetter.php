<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Application\Get;

use MarcusSports\Catalog\PartType\Domain\PartTypeCollection;
use MarcusSports\Catalog\PartType\Domain\Repository\PartTypeRepository;

final class PartTypeGetter
{
    public function __invoke(GetPartTypeRequest $request, PartTypeRepository $repository): array
    {
        $partTypes = $repository->findAll();
        return (new PartTypeCollection($partTypes))->toArray();
    }
}