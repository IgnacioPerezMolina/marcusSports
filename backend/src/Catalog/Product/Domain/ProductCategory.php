<?php

declare(strict_types=1);

namespace MarcusSports\Catalog\Product\Domain;
use MarcusSports\Shared\Domain\Enum\Valuable;
use MarcusSports\Shared\Domain\Enum\ValuableTrait;

enum ProductCategory: string implements Valuable
{
    use ValuableTrait;
    case CYCLING = 'cycling';
    case SURF = 'surf';
    case SNOWBOARDING = 'snowboarding';
    case RUNNING = 'running';
    case SWIMMING = 'swimming';
    case BOATING = 'boating';

    case OTHER = 'other';
}