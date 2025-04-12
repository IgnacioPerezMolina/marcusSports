<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use MarcusSports\Tests\Users\Domain\Mother\UserFirstNameMother;
use MarcusSports\Users\Domain\UserFirstName;
use PHPUnit\Framework\TestCase;
use TypeError;

class UserFirstNameTest extends TestCase
{
    public function test_user_first_name_should_be_created(): void
    {
        $firstName = UserFirstNameMother::random();

        $this->assertInstanceOf(UserFirstName::class, $firstName);
    }

    public function test_it_throws_type_error_when_not_string(): void
    {
        $this->expectException(TypeError::class);

        UserFirstNameMother::create(123);
    }
}