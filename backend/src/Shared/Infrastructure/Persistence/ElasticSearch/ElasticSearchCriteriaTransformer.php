<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Infrastructure\Persistence\ElasticSearch;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\CriteriaTransformer;

class ElasticSearchCriteriaTransformer implements CriteriaTransformer
{
    public function transform(Criteria $criteria, mixed $context, string $alias): mixed
    {
        return '';
    }
}