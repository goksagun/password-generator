<?php

namespace App\Tests\Controller\Api;

use Symfony\Component\HttpFoundation\Request;

class ApiTestCase extends \ApiTestCase\JsonApiTestCase
{
    public const HEADERS_CONTENT_TYPE_JSON = ['CONTENT_TYPE' => 'application/json'];

    public function request(
        string $method,
        string $uri = null,
        mixed $content = null,
        array $headers = []
    ): \Symfony\Component\HttpFoundation\Response {
        $headers += self::HEADERS_CONTENT_TYPE_JSON;

        $this->client->request(
            method: $method,
            uri: $uri,
            server: $headers,
            content: $content
        );

        return $this->client->getResponse();
    }

    public function post(
        string $uri,
        mixed $content = null,
        array $headers = []
    ): \Symfony\Component\HttpFoundation\Response {
        return $this->request(Request::METHOD_POST, $uri, $content, $headers);
    }

    protected function getContent(\Symfony\Component\HttpFoundation\Response $response
    ) {
        return json_decode($response->getContent());
    }

    protected function assertResponse(
        \Symfony\Component\HttpFoundation\Response $response,
        ?string $filename = null,
        int $statusCode = 200
    ): void {
        $filename = $this->getFilenameFromCalledTestMethod($filename);

        parent::assertResponse($response, $filename, $statusCode);
    }

    private function getFilenameFromCalledTestMethod(?string $filename): ?string
    {
        if (null === $filename) {
            $filename = debug_backtrace(limit: 3)[2]['function'];
            $filename = ltrim($filename, 'test_');
        }

        return $filename;
    }

    protected static function assertLength($expected, $actual): void
    {
        self::assertEquals($expected, strlen($actual));
    }
}