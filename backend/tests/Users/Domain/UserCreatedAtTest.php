<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use DateTime;
use MarcusSports\Tests\Users\Domain\Mother\UserCreatedAtMother;
use MarcusSports\Users\Domain\UserCreatedAt;
use PHPUnit\Framework\TestCase;

class UserCreatedAtTest extends TestCase
{
    public function test_user_created_at_should_be_created(): void
    {
        $date = UserCreatedAtMother::random();

        $this->assertInstanceOf(UserCreatedAt::class, $date);
    }

    public function test_it_returns_the_same_datetime(): void
    {
        $expectedDateTime = new DateTime('2024-04-12 14:00:00');

        $userCreatedAt = UserCreatedAtMother::create($expectedDateTime);

        $this->assertEquals($expectedDateTime, $userCreatedAt->value());

        $this->assertSame($expectedDateTime->format('Y-m-d H:i:s'), (string) $userCreatedAt);
    }

    public function test_static_create_returns_current_time(): void
    {
        $createdAt = UserCreatedAt::create();
        $this->assertInstanceOf(UserCreatedAt::class, $createdAt);

        $now = new DateTime();
        $timeDiff = abs($createdAt->value()->getTimestamp() - $now->getTimestamp());

        $this->assertLessThan(2, $timeDiff, 'The generated value by create() must be close to the current time.');
    }

    public function test_immutability_of_datetime_value(): void
    {
        $originalDate = new DateTime('2024-04-12 14:00:00');
        $userCreatedAt = UserCreatedAtMother::create($originalDate);

        $dtValue = $userCreatedAt->value();
        $dtValue->modify('+1 day');

        $this->assertEquals('2024-04-12 14:00:00', $userCreatedAt->value()->format('Y-m-d H:i:s'));
    }
}