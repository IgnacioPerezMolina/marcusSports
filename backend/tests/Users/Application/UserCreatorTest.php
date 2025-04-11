<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Application;

use MarcusSports\Tests\Users\Application\Mother\CreateUserRequestMother;
use MarcusSports\Tests\Users\Domain\Mother\UserMother;
use MarcusSports\Tests\Users\UserModuleUnitTestCase;
use MarcusSports\Users\Application\Create\UserCreator;

class UserCreatorTest extends UserModuleUnitTestCase
{
    private $creator;
    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new UserCreator();
    }

    public function test_it_should_be_create_a_valid_user(): void
    {
        $request = CreateUserRequestMother::random();

        $user = UserMother::fromRequest($request);

        $this->creator->__invoke($request, $this->repository());

        $this->shouldSave($user);
    }
}