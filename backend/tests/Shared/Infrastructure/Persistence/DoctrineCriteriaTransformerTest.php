<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Shared\Infrastructure\Persistence;

use Doctrine\ORM\QueryBuilder;
use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\Filter;
use MarcusSports\Shared\Domain\Criteria\FilterField;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\Criteria\FilterValue;
use MarcusSports\Shared\Domain\Criteria\Filters;
use MarcusSports\Shared\Domain\Criteria\Order;
use MarcusSports\Shared\Domain\Criteria\OrderBy;
use MarcusSports\Shared\Domain\Criteria\OrderType;
use MarcusSports\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaTransformer;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class DoctrineCriteriaTransformerTest extends MockeryTestCase
{
    private DoctrineCriteriaTransformer $transformer;
    private QueryBuilder $queryBuilder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBuilder = Mockery::mock(QueryBuilder::class);
        $this->transformer = new DoctrineCriteriaTransformer([
            'email' => 'email.value',
            'lastName' => 'lastName.value',
        ]);
    }

    public function test_it_applies_equal_filter(): void
    {
        $criteria = $this->createCriteriaWithFilter(
            'email',
            FilterOperator::EQUAL->value,
            'test@test.com'
        );

        $this->queryBuilder
            ->shouldReceive('andWhere')
            ->once()
            ->with('u.email.value = :param_0')
            ->andReturnSelf();
        $this->queryBuilder
            ->shouldReceive('setParameter')
            ->once()
            ->with('param_0', 'test@test.com')
            ->andReturnSelf();

        $result = $this->transformer->transform($this->queryBuilder, $criteria, 'u');

        $this->assertSame($this->queryBuilder, $result);
    }

    public function test_it_applies_contains_filter(): void
    {
        $criteria = $this->createCriteriaWithFilter(
            'lastName',
            FilterOperator::CONTAINS->value,
            'Last'
        );

        $this->queryBuilder
            ->shouldReceive('andWhere')
            ->once()
            ->with('u.lastName.value LIKE :param_0')
            ->andReturnSelf();
        $this->queryBuilder
            ->shouldReceive('setParameter')
            ->once()
            ->with('param_0', '%Last%')
            ->andReturnSelf();

        $result = $this->transformer->transform($this->queryBuilder, $criteria, 'u');

        $this->assertSame($this->queryBuilder, $result);
    }

    public function test_it_applies_order(): void
    {
        $criteria = new Criteria(
            new Filters([]),
            new Order(new OrderBy('lastName'), OrderType::DESC),
            null,
            null
        );

        $this->queryBuilder
            ->shouldReceive('orderBy')
            ->once()
            ->with('u.lastName.value', 'desc')
            ->andReturnSelf();

        $result = $this->transformer->transform($this->queryBuilder, $criteria, 'u');

        $this->assertSame($this->queryBuilder, $result);
    }

    public function test_it_applies_pagination(): void
    {
        $criteria = new Criteria(
            new Filters([]),
            Order::none(),
            10,
            2
        );

        $this->queryBuilder
            ->shouldReceive('setMaxResults')
            ->once()
            ->with(10)
            ->andReturnSelf();
        $this->queryBuilder
            ->shouldReceive('setFirstResult')
            ->once()
            ->with(10) // (2 - 1) * 10
            ->andReturnSelf();

        $result = $this->transformer->transform($this->queryBuilder, $criteria, 'u');

        $this->assertSame($this->queryBuilder, $result);
    }

    public function test_it_throws_exception_for_unsupported_operator(): void
    {
        $criteria = $this->createCriteriaWithFilter(
            'email',
            FilterOperator::GT->value,
            '100'
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported operator: >');

        $this->transformer->transform($this->queryBuilder, $criteria, 'u');
    }

    private function createCriteriaWithFilter(string $field, string $operator, string $value): Criteria
    {
        return new Criteria(
            new Filters([
                new Filter(
                    new FilterField($field),
                    FilterOperator::from($operator),
                    new FilterValue($value)
                ),
            ]),
            Order::none(),
            null,
            null
        );
    }
}