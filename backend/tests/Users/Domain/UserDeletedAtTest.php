<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use DateTimeImmutable;
use MarcusSports\Tests\Users\Domain\Mother\UserDeletedAtMother;
use MarcusSports\Users\Domain\UserDeletedAt;
use PHPUnit\Framework\TestCase;

class UserDeletedAtTest extends TestCase
{
    public function test_user_deleted_at_date_should_be_created(): void
    {
        $date = UserDeletedAtMother::random();

        $this->assertInstanceOf(UserDeletedAt::class, $date);
    }

    public function test_it_returns_the_same_datetime(): void
    {
        $expectedDateTime = new DateTimeImmutable('2024-04-12 14:00:00');

        $userDeletedAt = UserDeletedAtMother::create($expectedDateTime);

        $this->assertEquals($expectedDateTime, $userDeletedAt->value());

        $this->assertSame($expectedDateTime->format('Y-m-d H:i:s'), (string) $userDeletedAt);
    }

    public function test_static_create_returns_current_time(): void
    {
        $deletedAt = UserDeletedAt::create();
        $this->assertInstanceOf(UserDeletedAt::class, $deletedAt);

        $now = new DateTimeImmutable();
        $timeDiff = abs($deletedAt->value()->getTimestamp() - $now->getTimestamp());

        $this->assertLessThan(2, $timeDiff, 'The generated value by create() must be close to the current time.');
    }
}