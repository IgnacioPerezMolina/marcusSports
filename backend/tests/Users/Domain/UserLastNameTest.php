<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Shared\Domain\Exception\OutOfBoundsException;
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

    public function test_it_throws_exception_for_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UserLastNameMother::create('');
    }

    public function test_it_throws_type_error_when_not_string(): void
    {
        $this->expectException(TypeError::class);

        UserLastNameMother::create(123);
    }

    public function test_it_throws_exception_for_exceeding_max_length(): void
    {
        $longValue = str_repeat('a', 256);
        $this->expectException(OutOfBoundsException::class);

        UserLastNameMother::create($longValue);
    }

    public function test_it_throws_exception_for_invalid_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UserLastNameMother::create('Juan123');
    }

    public function test_it_allows_valid_special_characters(): void
    {
        $lastName = UserLastNameMother::create("O'Connor");

        $this->assertInstanceOf(UserLastName::class, $lastName);
        $this->assertSame("O'Connor", $lastName->value());

        $lastName = UserLastNameMother::create("Anna-María");

        $this->assertInstanceOf(UserLastName::class, $lastName);
        $this->assertSame("Anna-María", $lastName->value());
    }
}