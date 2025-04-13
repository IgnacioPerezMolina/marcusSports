<?php

declare(strict_types=1);

namespace MarcusSports\Tests\Users\Application;

use MarcusSports\Shared\Domain\Criteria\Criteria;
use MarcusSports\Shared\Domain\Criteria\FilterOperator;
use MarcusSports\Shared\Domain\PaginatedResult;
use MarcusSports\Tests\Users\Application\Mother\CreateUserRequestMother;
use MarcusSports\Tests\Users\Domain\Mother\UserMother;
use MarcusSports\Tests\Users\UserModuleUnitTestCase;
use MarcusSports\Users\Application\Create\UserCreator;
use RuntimeException;

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

//    public function test_it_should_throw_exception_when_duplicate_email_exists(): void
//    {
//        $request = CreateUserRequestMother::random();
//        $repository = $this->repository();
//
//        // Simulamos que ya existe al menos un usuario con ese email.
//        // Creamos un Criteria que busque usuarios con el email pasado
//        $criteria = Criteria::fromFilters([
//            [
//                'field'    => 'email.value',
//                'operator' => FilterOperator::EQUAL->value,
//                'value'    => strtolower($request->email())
//            ]
//        ]);
//
//        // Configuramos el mock del repositorio para que, al llamar a getByCriteria, devuelva un resultado con total > 0.
//        $paginatedResult = $this->createMock(\MarcusSports\Shared\Domain\PaginatedResult::class);
//        $paginatedResult->method('total')->willReturn(1);
//
//        $repository->expects($this->once())
//            ->method('getByCriteria')
//            ->with($this->callback(function ($criteriaPassed) use ($request) {
//                // Verificamos que el filtro tenga la estructura correcta.
//                // Por ejemplo, comprobamos que se ha definido la llave 'field' correctamente.
//                $filters = $criteriaPassed->filters();
//                // Aquí podrías agregar validaciones específicas sobre la estructura de los filters.
//                return is_array($filters);
//            }))
//            ->willReturn($paginatedResult);
//
//        // Se espera que, al detectarse duplicidad, se lance una excepción
//        $this->expectException(RuntimeException::class);
//        $this->expectExceptionMessage('The email is already in use.');
//
//        // Invocamos el caso de uso.
//        $this->creator->__invoke($request, $repository);
//    }
}