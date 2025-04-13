<?php

declare(strict_types=1);

namespace MarcusSports\Users\Infrastructure\Controller;

use MarcusSports\Users\Application\Create\CreateUserRequest;
use MarcusSports\Users\Application\Create\UserCreator;
use MarcusSports\Users\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPostController
{
    private UserCreator $userCreator;
    private UserRepository $repository;

    public function __construct(UserCreator $userCreator, UserRepository $repository)
    {
        $this->userCreator = $userCreator;
        $this->repository = $repository;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), false);
        $this->userCreator->__invoke(
            new CreateUserRequest(
                $data->id,
                $data->firstName,
                $data->lastName,
                $data->email,
                $data->password
            ),
            $this->repository
        );

        return new Response('', Response::HTTP_CREATED);
    }
}