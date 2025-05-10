<?php

declare(strict_types=1);

namespace MarcusSports\Users\User\Infrastructure\Controller;

use MarcusSports\Shared\Infrastructure\Criteria\SearchParamsToCriteriaConverter;
use MarcusSports\Users\User\Application\SearchByCriteria\SearchUsersByCriteriaRequest;
use MarcusSports\Users\User\Application\SearchByCriteria\UserSearcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class UserCriteriaController
{
    public function __construct(
        private UserSearcher $searcher,
        private SearchParamsToCriteriaConverter $converter
    ) {}


    public function __invoke(Request $request): Response
    {
        $requestData = new SearchUsersByCriteriaRequest(
            filters: $request->query->all()['filters'] ?? [],
            orderBy: $request->query->get('orderBy'),
            order: $request->query->get('order'),
            pageSize: $request->query->getInt('pageSize'),
            pageNumber: $request->query->getInt('pageNumber')
        );

        try {
            $criteria = $this->converter->convert(
                $requestData->filters(),
                $requestData->orderBy(),
                $requestData->order(),
                $requestData->pageSize(),
                $requestData->pageNumber()
            );
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $response = $this->searcher->__invoke($criteria);

        return new JsonResponse($response->toArray());
    }
}