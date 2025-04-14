<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\Auth\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetUserTokenControllerTest extends WebTestCase
{
    public function test_get_user_token()
    {
        $client = static::createClient();

        $client->request(
            'GET',
            'http://localhost/auth/login'
        );

        $this->assertResponseStatusCodeSame(201);
    }
}