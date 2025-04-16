<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;

use MarcusSports\Shared\Domain\Collection;

final class PartItemCollection extends Collection
{
    protected ?string $type = PartItem::class;

    public function __construct(array $elements = [])
    {
        parent::__construct($elements, $this->type);
    }
}
