<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Catalog\Product\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductsGetControllerTest extends WebTestCase
{
    public function test_get_all_products()
    {
        $client = static::createClient();

        $client->request(
            'GET',
            'http://localhost/product',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }
}