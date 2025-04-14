<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Users\User\Domain\UserFirstName;
use PHPUnit\Framework\TestCase;
use TypeError;

class UserFirstNameTest extends TestCase
{
    public function test_user_first_name_should_be_created(): void
    {
        $firstName = UserFirstNameMother::random();

        $this->assertInstanceOf(UserFirstName::class, $firstName);
    }

    public function test_it_throws_exception_for_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UserFirstNameMother::create('');
    }

    public function test_it_throws_type_error_when_not_string(): void
    {
        $this->expectException(TypeError::class);

        UserFirstNameMother::create(123);
    }

    public function test_it_throws_exception_for_invalid_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UserFirstNameMother::create('Juan123');
    }

    public function test_it_throws_exception_for_exceeding_max_length(): void
    {
        $longValue = str_repeat('a', 256);
        $this->expectException(InvalidArgumentException::class);

        UserFirstNameMother::create($longValue);
    }

    public function test_it_allows_valid_special_characters(): void
    {
        $firstName = UserFirstNameMother::create("O'Connor");

        $this->assertInstanceOf(UserFirstName::class, $firstName);
        $this->assertSame("O'Connor", $firstName->value());

        $firstName = UserFirstNameMother::create("Anna-María");

        $this->assertInstanceOf(UserFirstName::class, $firstName);
        $this->assertSame("Anna-María", $firstName->value());
    }
}