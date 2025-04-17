<?php

declare(strict_types=1);


namespace MarcusSports\Catalog\Product\Application\Get;

use Symfony\Component\HttpFoundation\Request;

class GetProductsRequest
{
    public function __construct(Request $request)
    {
    }
}