<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\User\Domain;

use MarcusSports\Shared\Domain\Exception\InvalidArgumentException;
use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase
{
    public function test_user_email_should_be_created(): void
    {
        $userEmail = UserEmailMother::random();

        $this->assertInstanceOf(\MarcusSports\Users\User\Domain\UserEmail::class, $userEmail);
    }

    public function test_it_throws_exception_for_invalid_format(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UserEmailMother::create('example');
    }

    public function test_it_throws_exception_for_invalid_domain(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UserEmailMother::create('user@invalid-domain');
    }
}