<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Application;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filters;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsCriteriaFiltersParser;
use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsToCriteriaConverter;
use MarcusSports\Users\User\Application\SearchByCriteria\UserSearcher;
use MarcusSports\Users\User\Application\SearchByCriteria\UsersSearchResponse;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class UserSearcherTest extends MockeryTestCase
{
    private UserSearcher $searcher;
    private UserRepository $repository;
    private SearchParamsToCriteriaConverter $criteriaConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepository::class);
        $parser = new SearchParamsCriteriaFiltersParser();
        $this->criteriaConverter = new SearchParamsToCriteriaConverter($parser);
        $this->searcher = new UserSearcher($this->repository, $this->criteriaConverter);
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

        $this->assertInstanceOf(UsersSearchResponse::class, $result);
        $paginatedResult = $result->paginatedResult();
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertSame($users, $paginatedResult->items());
        $this->assertSame($total, $paginatedResult->total());
        $this->assertSame(2, $paginatedResult->currentPage());
        $this->assertSame(10, $paginatedResult->itemsPerPage());
        $this->assertSame(5, $paginatedResult->totalPages());
        $this->assertEquals([], $result->filters());
        $this->assertNull($result->orderBy());
        $this->assertNull($result->order());
    }
}