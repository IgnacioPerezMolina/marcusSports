<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\User\Application;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filters;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Users\User\Application\SearchByCriteria\UserSearcher;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class UserSearcherTest extends MockeryTestCase
{
    private UserSearcher $searcher;
    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepository::class);
        $this->searcher = new UserSearcher($this->repository);
    }

    public function test_it_searches_users_with_pagination(): void
    {
        $criteria = new Criteria(new Filters([]), Order::none(), 10, 2);
        $users = [Mockery::mock('MarcusSports\Users\User\Domain\User')];
        $total = 50;

        $this->repository
            ->shouldReceive('getByCriteria')
            ->once()
            ->with(Mockery::type(Criteria::class))
            ->andReturn(['items' => $users, 'total' => $total]);

        $result = $this->searcher->__invoke($criteria);

        $this->assertInstanceOf(PaginatedResult::class, $result);
        $this->assertSame($users, $result->items());
        $this->assertSame($total, $result->total());
        $this->assertSame(2, $result->currentPage());
        $this->assertSame(10, $result->itemsPerPage());
        $this->assertSame(5, $result->totalPages());
    }
}