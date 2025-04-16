<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartType\Domain;

use MarcusSports\Shared\Domain\Collection;

final class PartTypeCollection extends Collection
{
    public ?string $type = PartType::class;

    public function __construct(array $elements = [])
    {
        parent::__construct($elements, $this->type);
    }
}