<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Application;

use MarcusSports\Tests\Users\User\Application\Mother\CreateUserRequestMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use MarcusSports\Tests\Users\UsersModuleUnitTestCase;
use MarcusSports\Users\User\Application\Create\UserCreator;
use MarcusSports\Users\User\Domain\User;
use MarcusSports\Users\User\Domain\UserCreatedAt;
use MarcusSports\Users\User\Domain\UserEmail;
use MarcusSports\Users\User\Domain\UserFirstName;
use MarcusSports\Users\User\Domain\UserLastName;
use MarcusSports\Users\User\Domain\UserPassword;
use MarcusSports\Users\User\Domain\UserUpdatedAt;
use MarcusSports\Users\User\Domain\UserUuid;
use RuntimeException;

class UsersCreatorTest extends UsersModuleUnitTestCase
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

    public function test_it_should_throw_exception_when_repository_fails(): void
    {
        $request = CreateUserRequestMother::random();

        $repository = $this->repository();

        $repository->expects($this->once())
            ->method('save')
            ->willThrowException(new RuntimeException('Duplicate user'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate user');

        $this->creator->__invoke($request, $repository);
    }

    public function test_it_should_throw_exception_when_duplicate_email_exists(): void
    {
        $request = CreateUserRequestMother::random();
        $repository = $this->repository();

        $firstUser = new User(
            new UserUuid($request->id()),
            new UserFirstName($request->firstName()),
            new UserLastName($request->lastName()),
            new UserEmail($request->email()),
            new UserPassword($request->password()),
            UserCreatedAt::create(),
            UserUpdatedAt::create(),
            null
        );

        $this->creator->__invoke($request, $repository);

        $secondRequest = CreateUserRequestMother::create(
            UserUuidMother::random(),
            UserFirstNameMother::random(),
            UserLastNameMother::random(),
            UserEmailMother::create($request->email()),
            UserPasswordMother::random()
        );

        $secondUser = new User(
            new UserUuid($secondRequest->id()),
            new UserFirstName($secondRequest->firstName()),
            new UserLastName($secondRequest->lastName()),
            new UserEmail($secondRequest->email()),
            new UserPassword($secondRequest->password()),
            UserCreatedAt::create(),
            UserUpdatedAt::create(),
            null
        );

        $this->shouldFindByEmail($secondUser, $firstUser);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The email is already in use.');

        $this->creator->__invoke($secondRequest, $repository);
    }
}