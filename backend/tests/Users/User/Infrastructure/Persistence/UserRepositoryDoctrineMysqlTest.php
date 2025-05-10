<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Infrastructure\Persistence;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\FilterField;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\Criteria\Filters;
use MarcusSports\Shared\Domain\Criteria\FilterValue;
use MarcusSports\Shared\Domain\Criteria\Order;
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

    public function test_it_finds_users_with_pagination(): void
    {
        $user1 = UserMother::create(
            UserUuidMother::create('3816d6ae-f2a9-4624-b0c3-35cfab0ed41d'),
            UserFirstNameMother::create('Test'),
            UserLastNameMother::create('Last'),
            UserEmailMother::create('test@test.com'),
            UserRoleMother::user(),
            UserPasswordMother::random(),
            UserCreatedAtMother::random(),
            UserUpdatedAtMother::random(),
            UserDeletedAtMother::create(null)
        );
        $user2 = UserMother::create(
            UserUuidMother::random(),
            UserFirstNameMother::create('Another'),
            UserLastNameMother::create('User'),
            UserEmailMother::create('another@test.com'),
            UserRoleMother::user(),
            UserPasswordMother::random(),
            UserCreatedAtMother::random(),
            UserUpdatedAtMother::random(),
            UserDeletedAtMother::create(null)
        );

        $this->repository->save($user1);
        $this->repository->save($user2);
        $this->entityManager->flush();

        $criteria = new Criteria(
            new Filters([
                new Filter(
                    new FilterField('email'),
                    FilterOperator::from('='),
                    new FilterValue('test@test.com')
                ),
            ]),
            Order::none(),
            1,
            1
        );

        $result = $this->repository->getByCriteria($criteria);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('items', $result);
        $this->assertArrayHasKey('total', $result);
        $this->assertCount(1, $result['items']);
        $this->assertSame('test@test.com', $result['items'][0]->email()->value());
        $this->assertSame(1, $result['total']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
