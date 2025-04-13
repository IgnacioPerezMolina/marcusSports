<?php

declare(strict_types=1);


namespace MarcusSports\Users\Domain;

use MarcusSports\Shared\Domain\Collection;

class UserCollection extends Collection
{
    private string $type = User::class;

    public function __construct(array $elements = [])
    {
        parent::__construct($elements, $this->type);
    }
}