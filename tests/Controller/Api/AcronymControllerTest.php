<?php

namespace App\Tests\Controller\Api;

class AcronymControllerTest extends ApiTestCase
{
    public function test_given_a_phrase_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "phrase": "Better to have loved and lost than never to have loved at all"
        }
        JSON;

        $response = $this->request(
            'POST',
            '/api/acronym/generate',
            $content,
        );

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

        $response = $this->request(
            'POST',
            '/api/acronym/generate',
            $content,
        );

        $this->assertResponse($response, 'given_empty_string_then_return_error', 422);
    }

    public function test_given_nothing_then_return_error(): void
    {
        $content = <<<'JSON'

        JSON;

        $this->request(
            'POST',
            '/api/acronym/generate',
            $content,
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'given_nothing_then_return_error', 422);
    }
}
