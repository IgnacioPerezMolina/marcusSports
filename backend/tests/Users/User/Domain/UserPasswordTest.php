<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain;

use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase
{
    public function test_password_is_hashed_correctly(): void
    {
        $plainPassword = 'secretPassword123';

        $userPassword = UserPasswordMother::fromPlain($plainPassword);

        $this->assertNotEquals($plainPassword, $userPassword->value());

        $this->assertTrue($userPassword->verify($plainPassword));

        $this->assertFalse($userPassword->verify('wrongPassword'));
    }
}