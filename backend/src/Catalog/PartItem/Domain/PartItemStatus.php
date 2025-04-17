<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PartItem\Domain;
use MarcusSports\Shared\Domain\Enum\Valuable;
use MarcusSports\Shared\Domain\Enum\ValuableTrait;

enum PartItemStatus: string implements Valuable
{
    use ValuableTrait;
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case OUT_OF_STOCK = 'out_of_stock';
}