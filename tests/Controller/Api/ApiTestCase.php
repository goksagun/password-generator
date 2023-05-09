<?php

namespace App\Tests\Controller\Api;

class ApiTestCase extends \ApiTestCase\JsonApiTestCase
{
    public function request(
        string $method,
        string $uri,
        mixed $content = null,
        array $headers = []
    ): \Symfony\Component\HttpFoundation\Response {
        $headers += ['CONTENT_TYPE' => 'application/json'];

        $this->client->request(
            method: $method,
            uri: $uri,
            server: $headers,
            content: $content
        );

        return $this->client->getResponse();
    }
}