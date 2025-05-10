<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Criteria;

interface CriteriaTransformer
{
    public function transform(Criteria $criteria, mixed $context, string $alias): mixed;
}