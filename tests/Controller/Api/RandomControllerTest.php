<?php

namespace App\Tests\Controller\Api;

use App\Generator\RandomGenerator;

class RandomControllerTest extends ApiTestCase
{
    protected const API_RANDOM_GENERATE_URI = '/api/random/generate';

    public function test_given_none_then_return_success(): void
    {
        $response = $this->post(self::API_RANDOM_GENERATE_URI);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);
        $this->assertLength(8, $this->getContent($response)->data->random);
    }

    public function test_given_length_then_return_success(): void
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
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_alpha_then_return_success(): void
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

        $this->assertMatchesRegularExpression($this->getAlphaRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getNumericRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_alpha_lower_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "strategy": "alpha-lower"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression($this->getAlphaLowerRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getAlphaUpperRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_alpha_upper_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "strategy": "alpha-upper"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression($this->getAlphaUpperRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getAlphaLowerRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_numeric_then_return_success(): void
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

        $this->assertMatchesRegularExpression($this->getNumericRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getAlphaRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_alphanumeric_then_return_success(): void
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

        $this->assertMatchesRegularExpression($this->getAlnumRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_alphanumeric_lower_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "strategy": "alphanumeric-lower"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression($this->getAlphaNumericLowerRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getAlphaUpperRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
    }

    public function test_given_strategy_alphanumeric_upper_then_return_success(): void
    {
        $content = <<<'JSON'
        {
            "strategy": "alphanumeric-upper"
        }
        JSON;

        $response = $this->post(self::API_RANDOM_GENERATE_URI, $content);

        $this->assertResponseIsSuccessful();
        $this->assertResponse($response, statusCode: 201);

        $actual = $this->getContent($response)->data->random;

        $this->assertMatchesRegularExpression($this->getAlphaNumericUpperRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getAlphaLowerRegexPattern(), $actual);
        $this->assertDoesNotMatchRegularExpression($this->getSpecialRegexPattern(), $actual);
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

        $this->assertMatchesRegularExpression($this->getComplexRegexPattern(), $actual);
    }

    private function getAlphaRegexPattern(): string
    {
        return '/^[a-zA-Z]+$/';
    }

    private function getAlphaLowerRegexPattern(): string
    {
        return '/^[a-z]+$/';
    }

    private function getAlphaUpperRegexPattern(): string
    {
        return '/^[A-Z]+$/';
    }

    private function getNumericRegexPattern(): string
    {
        return '/^[0-9]+$/';
    }

    private function getSpecialRegexPattern(): string
    {
        return '/^[\]\[}{@_!#$%^&*()<>?|~:;=\-+]+$/';
    }

    private function getAlnumRegexPattern(): string
    {
        return '/^[a-zA-Z0-9]+$/';
    }

    private function getComplexRegexPattern(): string
    {
        return '/^[a-zA-Z0-9\]\[}{@_!#$%^&*()<>?|~:;=\-+]+$/';
    }

    private function getAlphaNumericLowerRegexPattern(): string
    {
        return    '/^[a-z0-9]+$/';
    }

    private function getAlphaNumericUpperRegexPattern(): string
    {
        return    '/^[A-Z0-9]+$/';
    }
}
