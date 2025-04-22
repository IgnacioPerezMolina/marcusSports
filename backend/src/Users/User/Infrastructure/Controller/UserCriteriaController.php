<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Controller;

use MarcusSports\Users\User\Application\SearchByCriteria\UserSearcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCriteriaController
{
    public function __construct(private UserSearcher $searcher)
    {
    }

    public function __invoke(Request $request): Response
    {
        $queryParams = $request->query->all();

        try {
            $response = $this->searcher->__invoke($queryParams);
        } catch (\InvalidArgumentException $e) {
            error_log('Search error: ' . $e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            error_log('Search error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Search failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($response->toArray());
    }
}