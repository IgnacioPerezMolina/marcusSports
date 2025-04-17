<?php

declare(strict_types=1);


namespace Catalog\Product\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductPostControllerTest extends WebTestCase
{
    public function test_customizable_product_should_be_created()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            'http://localhost/product',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "id" => "407294aa-1509-43cf-8277-930caa247d11",
                "name" => "Product Test",
                "description" => "Description",
                "category" => "cycling",
                "basePrice" => 50.00
            ]),
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }
}