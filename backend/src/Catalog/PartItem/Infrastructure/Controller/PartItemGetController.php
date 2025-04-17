<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartItem\Infrastructure\Controller;

use MarcusSports\Catalog\PartItem\Application\Get\GetPartItemRequest;
use MarcusSports\Catalog\PartItem\Application\Get\PartItemGetter;
use MarcusSports\Catalog\PartItem\Domain\Repository\PartItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartItemGetController
{
    public function __construct(
        private PartItemGetter $partItemGetter,
        private PartItemRepository $repository
    )
    {
    }

    public function __invoke(Request $request)
    {
        $partItems = $this->partItemGetter->__invoke(new GetPartItemRequest($request), $this->repository);

        return new Response(
            json_encode($partItems),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}