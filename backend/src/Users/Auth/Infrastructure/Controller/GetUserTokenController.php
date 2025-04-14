<?php

declare(strict_types=1);


namespace MarcusSports\Users\Auth\Infrastructure\Controller;

use MarcusSports\Users\Auth\Application\Get\GetTokenRequest;
use MarcusSports\Users\Auth\Application\Get\LoginService;
use MarcusSports\Users\Auth\Domain\TokenGeneratorInterface;
use MarcusSports\Users\User\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetUserTokenController
{
    private LoginService $loginService;
    private UserRepository $repository;
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(LoginService $loginService, UserRepository $repository, TokenGeneratorInterface $tokenGenerator)
    {
        $this->loginService = $loginService;
        $this->repository = $repository;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $getTokenRequest = new GetTokenRequest(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        try {
            $authSession = $this->loginService->__invoke(
                $getTokenRequest,
                $this->repository,
                $this->tokenGenerator);

            return new JsonResponse([
                'accessToken'  => $authSession->accessToken(),
                'refreshToken' => $authSession->refreshToken(),
                'expiresAt'    => $authSession->expiresAt(),
                'createdAt'    => $authSession->createdAt(),
                'status'       => $authSession->status(),
            ], Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }
}