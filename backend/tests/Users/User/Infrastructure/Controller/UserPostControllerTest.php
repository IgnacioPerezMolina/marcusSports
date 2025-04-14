<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Infrastructure\Controller;

use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserPostControllerTest extends WebTestCase
{
    public function test_user_should_be_created()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            'http://localhost/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'id' => UserUuidMother::random()->value(),
                'firstName' => UserFirstNameMother::random()->value(),
                'lastName' => UserLastNameMother::random()->value(),
                'email' => UserEmailMother::random()->value(),
                'password' => UserPasswordMother::random()->value(),
            ])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }
}
