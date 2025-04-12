<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Infrastructure\Persistence;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use MarcusSports\Tests\Users\Domain\Mother\UserCreatedAtMother;
use MarcusSports\Tests\Users\Domain\Mother\UserDeletedAtMother;
use MarcusSports\Tests\Users\Domain\Mother\UserEmailMother;
use MarcusSports\Tests\Users\Domain\Mother\UserFirstNameMother;
use MarcusSports\Tests\Users\Domain\Mother\UserIdMother;
use MarcusSports\Tests\Users\Domain\Mother\UserLastNameMother;
use MarcusSports\Tests\Users\Domain\Mother\UserPasswordMother;
use MarcusSports\Tests\Users\Domain\Mother\UserUpdatedAtMother;
use MarcusSports\Users\Domain\User;
use MarcusSports\Users\Domain\Repository\UserRepository;
use MarcusSports\Tests\Users\Domain\Mother\UserMother;
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

        // (Opcional) Limpia la base de datos de test para asegurar que cada test arranca en un estado limpio,
        // ya sea mediante un comando custom o mediante alguna estrategia de borrado.
    }

    public function test_it_can_save_and_retrieve_a_user(): void
    {
        $user = UserMother::random();

        $this->repository->save($user);

        // TODO which its better
        $savedUser = $this->entityManager->getRepository(User::class)
            ->find($user->id()->value());
        $savedUser2 = $this->repository->find($user->id());

        $this->assertNotNull($savedUser);
        $this->assertSame($user->id()->value(), $savedUser->id()->value());
        $this->assertSame($user->firstName()->value(), $savedUser->firstName()->value());
        $this->assertSame($user->lastName()->value(), $savedUser->lastName()->value());
        $this->assertSame($user->email()->value(), $savedUser->email()->value());
        $this->assertSame($user->password()->value(), $savedUser->password()->value());
        // TODO
//        print_r($user->createdAt()->value());
//        print_r($savedUser->createdAt()->value());
//        $this->assertSame($user->createdAt()->value(), $savedUser->createdAt()->value());
//        $this->assertSame($user->updatedAt()->value(), $savedUser->updatedAt()->value());
//        $this->assertSame($user->deletedAt()->value(), $savedUser->deletedAt()->value());
    }

    public function test_it_throws_exception_when_duplicate_user_is_saved(): void
    {
        $user = UserMother::random();

        $this->repository->save($user);
        $this->entityManager->clear();

        $duplicateUser = UserMother::create(
            UserIdMother::create($user->id()->value()),
            UserFirstNameMother::create($user->firstName()->value()),
            UserLastNameMother::create($user->lastName()->value()),
            UserEmailMother::create($user->email()->value()),
            UserPasswordMother::create($user->password()->value()),
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
