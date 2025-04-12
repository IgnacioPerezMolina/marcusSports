<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use DateTime;
use MarcusSports\Tests\Users\Domain\Mother\UserUpdatedAtMother;
use MarcusSports\Users\Domain\UserUpdatedAt;
use PHPUnit\Framework\TestCase;

class UserUpdatedAtTest extends TestCase
{
    public function test_user_updated_at_date_should_be_created(): void
    {
        $date = UserUpdatedAtMother::random();

        $this->assertInstanceOf(UserUpdatedAt::class, $date);
    }

    public function test_it_returns_the_same_datetime(): void
    {
        $expectedDateTime = new DateTime('2023-04-12 14:00:00');

        $userUpdatedAt = UserUpdatedAtMother::create($expectedDateTime);

        $this->assertEquals($expectedDateTime, $userUpdatedAt->value());

        $this->assertSame($expectedDateTime->format('Y-m-d H:i:s'), (string) $userUpdatedAt);
    }

    public function test_static_create_returns_current_time(): void
    {
        $updatedAt = UserUpdatedAt::create();
        $this->assertInstanceOf(UserUpdatedAt::class, $updatedAt);

        $now = new DateTime();
        $timeDiff = abs($updatedAt->value()->getTimestamp() - $now->getTimestamp());

        $this->assertLessThan(2, $timeDiff, 'The generated value by create() must be close to the current time.');
    }

    public function test_immutability_of_datetime_value(): void
    {
        $originalDate = new DateTime('2023-04-12 14:00:00');
        $userUpdatedAt = UserUpdatedAtMother::create($originalDate);

        $dtValue = $userUpdatedAt->value();
        $dtValue->modify('+1 day');

        $this->assertEquals('2023-04-12 14:00:00', $userUpdatedAt->value()->format('Y-m-d H:i:s'));
    }
}