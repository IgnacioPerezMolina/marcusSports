<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Infrastructure\Controller;

use MarcusSports\Tests\Users\Domain\Mother\UserUuidMother;
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
                'uuid' => UserUuidMother::random()->value(),
                'firstName' => 'Ignacio',
                'lastName' => 'Garcia',
                'email' => 'email@email.com',
                'password' => '12345678'
            ])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }
}
