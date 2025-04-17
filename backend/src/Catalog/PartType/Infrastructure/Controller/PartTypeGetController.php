<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\PartType\Infrastructure\Controller;

use MarcusSports\Catalog\PartType\Application\Get\GetPartTypeRequest;
use MarcusSports\Catalog\PartType\Application\Get\PartTypeGetter;
use MarcusSports\Catalog\PartType\Domain\Repository\PartTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartTypeGetController
{
    public function __construct(
        private PartTypeGetter $partTypeGetter,
        private PartTypeRepository $repository
    )
    {
    }

    public function __invoke(Request $request)
    {
        $partTypes = $this->partTypeGetter->__invoke(new GetPartTypeRequest($request), $this->repository);

//        dd($partTypes);
        return new Response(
            json_encode($partTypes),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}