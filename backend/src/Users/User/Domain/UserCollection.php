<?php

declare(strict_types=1);


namespace MarcusSports\Users\User\Domain;

use MarcusSports\Shared\Domain\Collection;

class UserCollection extends Collection
{
    public ?string $type = User::class;

    public function __construct(array $elements = [])
    {
        parent::__construct($elements, $this->type);
    }

    protected function type(): string
    {
        return User::class;
    }
}