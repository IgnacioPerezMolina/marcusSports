<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use PHPUnit\Framework\TestCase;

class UserUuidTest extends TestCase
{
    public function test_user_id_should_be_created(): void
    {
        $validUuid = UserUuidMother::random();

        $this->assertInstanceOf(\MarcusSports\Users\User\Domain\UserUuid::class, $validUuid);
    }

    public function test_it_throws_exception_for_invalid_uuid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UserUuidMother::create('invalid-uuid');
    }
}