<?php

namespace App\Tests\Controller\Api;

class RandomControllerTest extends ApiTestCase
{
    protected const API_RANDOM_GENERATE_URI = '/api/random/generate';

    public function test_given_none_then_return_success(): void
    {
        $response = $this->request('POST', self::API_RANDOM_GENERATE_URI);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);
        $this->assertLength(8, $this->getContent($response)->data->random);
    }

    public function test_given_length_then_return_success()
    {
        $content = <<<'JSON'
        {
            "length": 40
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertLength(40, $actual);
        $this->assertDoesNotMatchRegularExpression('/^[0-9]+$/', $actual);
        $this->assertDoesNotMatchRegularExpression('/^[@_!#$%^&*()<>?\/|}{~:\]]+$/', $actual);
    }

    public function test_given_strategy_alpha_then_return_success()
    {
        $content = <<<'JSON'
        {
            "strategy": "alpha"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression('/^[a-zA-Z]+$/', $actual);
        $this->assertDoesNotMatchRegularExpression('/^[0-9]+$/', $actual);
        $this->assertDoesNotMatchRegularExpression('/^[@_!#$%^&*()<>?\/|}{~:\]]+$/', $actual);
    }

    public function test_given_strategy_numeric_then_return_success()
    {
        $content = <<<'JSON'
        {
            "strategy": "numeric"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression('/^[0-9]+$/', $actual);
        $this->assertDoesNotMatchRegularExpression('/^[a-zA-Z]+$/', $actual);
        $this->assertDoesNotMatchRegularExpression('/^[@_!#$%^&*()<>?\/|}{~:\]]+$/', $actual);
    }

    public function test_given_strategy_alphanumeric_then_return_success()
    {
        $content = <<<'JSON'
        {
            "strategy": "alphanumeric"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]+$/', $actual);
        $this->assertDoesNotMatchRegularExpression('/^[@_!#$%^&*()<>?\/|}{~:\]]+$/', $actual);
    }

    public function test_given_strategy_complex_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "strategy": "complex"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression('/^[0-9a-zA-Z@_!#$%^&*()<>?\/|}{~:\]]+$/', $actual);
    }
}
