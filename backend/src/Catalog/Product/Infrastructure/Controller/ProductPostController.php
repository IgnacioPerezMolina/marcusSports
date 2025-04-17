<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Infrastructure\Controller;

use MarcusSports\Catalog\Product\Application\Create\CreateProductRequest;
use MarcusSports\Catalog\Product\Application\Create\ProductCreator;
use MarcusSports\Catalog\Product\Domain\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductPostController
{
    private ProductCreator $productCreator;
    private ProductRepository $repository;

    public function __construct(ProductCreator $productCreator, ProductRepository $repository)
    {
        $this->productCreator = $productCreator;
        $this->repository = $repository;
    }

    public function __invoke(Request $request) : Response
    {
        $data = json_decode($request->getContent(), false);

        $this->productCreator->__invoke(
            new CreateProductRequest(
                $data->id,
                $data->name,
                $data->description,
                $data->category,
                $data->basePrice
            ),
            $this->repository
        );

        return new Response('', Response::HTTP_CREATED);
    }
}