<?php

namespace App\Tests\Controller\Api;

use ApiTestCase\JsonApiTestCase;

class PasswordControllerTest extends JsonApiTestCase
{
    public function test_given_a_phrase_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "phrase": "Better to have loved and lost than never to have loved at all"
        }
        JSON;

        $this->client->request(
            'POST', '/api/password/generate', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );

        $response = $this->client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, 'given_a_phrase_then_return_success');
    }

    public function test_given_phrase_empty_string_then_return_error(): void
    {
        $content = <<<'JSON'
        {
            "phrase": ""
        }
        JSON;

        $this->client->request(
            'POST', '/api/password/generate', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'given_empty_string_then_return_error', 422);
    }

    public function test_given_nothing_then_return_error(): void
    {
        $content = <<<'JSON'

        JSON;

        $this->client->request(
            'POST', '/api/password/generate', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            $content
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'given_nothing_then_return_error', 422);
    }
}
