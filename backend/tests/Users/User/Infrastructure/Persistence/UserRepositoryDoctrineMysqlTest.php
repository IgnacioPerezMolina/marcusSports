<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Infrastructure\Persistence;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use MarcusSports\Tests\Users\User\Domain\Mother\UserCreatedAtMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserDeletedAtMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserRoleMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUpdatedAtMother;
use MarcusSports\Tests\Users\User\Domain\Mother\UserUuidMother;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UserRepositoryDoctrineMysqlTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;
    private UserRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->repository = static::getContainer()->get(UserRepository::class);
    }

    public function test_it_can_save_and_retrieve_a_user(): void
    {
        $user = UserMother::random();

        $this->repository->save($user);

        $savedUser = $this->repository->find($user->id());

        $this->assertNotNull($savedUser);
        $this->assertSame($user->id()->value(), $savedUser->id()->value());
        $this->assertSame($user->firstName()->value(), $savedUser->firstName()->value());
        $this->assertSame($user->lastName()->value(), $savedUser->lastName()->value());
        $this->assertSame($user->email()->value(), $savedUser->email()->value());
        $this->assertSame($user->password()->value(), $savedUser->password()->value());
    }

    public function test_it_throws_exception_when_duplicate_user_is_saved(): void
    {
        $user = UserMother::random();

        $this->repository->save($user);
        $this->entityManager->clear();

        $duplicateUser = UserMother::create(
            UserUuidMother::create($user->id()->value()),
            UserFirstNameMother::create($user->firstName()->value()),
            UserLastNameMother::create($user->lastName()->value()),
            UserEmailMother::create($user->email()->value()),
            UserRoleMother::user(),
            UserPasswordMother::fromPlain($user->password()->value()),
            UserCreatedAtMother::create($user->createdAt()->value()),
            UserUpdatedAtMother::create($user->updatedAt()->value()),
            UserDeletedAtMother::create($user->deletedAt())
        );

        $this->expectException(UniqueConstraintViolationException::class);

        $this->repository->save($duplicateUser);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
