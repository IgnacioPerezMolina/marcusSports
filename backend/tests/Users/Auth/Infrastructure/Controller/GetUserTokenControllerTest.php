<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Users\Auth\Infrastructure\Controller;

use MarcusSports\Tests\Users\User\Application\Mother\CreateUserRequestMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use MarcusSports\Users\User\Application\Create\UserCreator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetUserTokenControllerTest extends WebTestCase
{
    public function test_get_user_token_successful(): void
    {
        $client = static::createClient();

        $userCreator = self::getContainer()->get(UserCreator::class);
        $repository = self::getContainer()->get('MarcusSports\Users\User\Domain\Repository\UserRepository');

        $request = CreateUserRequestMother::create(
            UserUuidMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::create('test@example.com'),
            UserPasswordMother::create('Password123')
        );

        $userCreator->__invoke($request, $repository);

        $client->request('POST', '/auth/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'test@example.com',
            'password' => 'Password123',
        ]));

        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($client->getResponse()->getContent());
    }
}