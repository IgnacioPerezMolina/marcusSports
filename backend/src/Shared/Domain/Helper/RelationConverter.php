<?php

declare(strict_types=1);


namespace MarcusSports\Shared\Domain\Helper;

use Doctrine\Common\Collections\Collection;

class RelationConverter
{
    public static function convert(?Collection $relations): array
    {
        if ($relations->isEmpty()) {
            return [];
        }

        $result = [];

        foreach ($relations as $relation) {
            $result[] = $relation->toArray();
        }

        return $result;
    }
}