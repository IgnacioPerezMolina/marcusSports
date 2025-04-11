<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use MarcusSports\Tests\Users\Domain\Mother\UserMother;
use MarcusSports\Users\Domain\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user_should_be_created()
    {
        $user = UserMother::random();

        $this->assertInstanceOf(User::class, $user);
    }
}