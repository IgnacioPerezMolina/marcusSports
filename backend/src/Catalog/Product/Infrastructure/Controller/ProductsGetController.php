<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Infrastructure\Controller;

use MarcusSports\Catalog\Product\Application\Get\GetProductsRequest;
use MarcusSports\Catalog\Product\Application\Get\ProductGetter;
use MarcusSports\Catalog\Product\Domain\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsGetController
{

    public function __construct(
        private ProductGetter     $productGetter,
        private ProductRepository $repository
    )
    {
    }

    public function __invoke(Request $request)
    {
        $products = $this->productGetter->__invoke(new GetProductsRequest($request), $this->repository);

        return new Response(
            json_encode($products),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}