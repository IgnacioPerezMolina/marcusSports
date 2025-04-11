<?php

declare(strict_types=1);


namespace MarcusSports\Tests\Shared\Infrastructure;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class HealthCheckGetControllerTest extends TestCase
{
    public function test_get_health_check_is_valid() {
        $client = new Client();
        $response = $client->get('http://localhost/health-check', [
            'headers' => ['Accept' => 'application/json']
        ]);

        $data = json_decode((string)$response->getBody(), true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('status', $data);
        $this->assertSame('ok', $data['status']);
    }
}