<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Infrastructure\Controller;

use MarcusSports\Tests\Users\Domain\Mother\UserIdMother;
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
                'id' => UserIdMother::random()->value(),
                'firstName' => 'Ignacio',
                'lastName' => 'Garcia',
                'email' => 'email@email.com',
                'password' => '12345678'
            ])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

//        $this->assertSame(201, $response->getStatusCode());
    }
}