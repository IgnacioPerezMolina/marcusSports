<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use MarcusSports\Tests\Users\Domain\Mother\UserLastNameMother;
use MarcusSports\Users\Domain\UserLastName;
use PHPUnit\Framework\TestCase;
use TypeError;

class UserLastNameTest extends TestCase
{
    public function test_user_last_name_should_be_created(): void
    {
        $lastName = UserLastNameMother::random();

        $this->assertInstanceOf(UserLastName::class, $lastName);
    }

    public function test_it_throws_type_error_when_not_string(): void
    {
        $this->expectException(TypeError::class);

        UserLastNameMother::create(123);
    }
}