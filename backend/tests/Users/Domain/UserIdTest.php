<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Tests\Users\Domain\Mother\UserIdMother;
use MarcusSports\Users\Domain\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    public function test_user_id_should_be_created(): void
    {
        $validUuid = UserIdMother::random();

        $this->assertInstanceOf(UserId::class, $validUuid);
    }

    public function test_it_throws_exception_for_invalid_uuid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UserIdMother::create('invalid-uuid');
    }
}