<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\PriceModifier\Domain;

use MarcusSports\Shared\Domain\Enum\Valuable;
use MarcusSports\Shared\Domain\Enum\ValuableTrait;

enum PriceModifierScope: string implements Valuable
{
    use ValuableTrait;
    case GLOBAL = 'global';
    case PART = 'part';
}
