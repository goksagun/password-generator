<?php

namespace App\Tests\Generator;

use App\Generator\RandomGenerator;
use PHPUnit\Framework\TestCase;

class RandomGeneratorTest extends TestCase
{

    /**
     * @dataProvider provideGenerateFromMatchesAlphaData
     */
    public function testGenerateFromMatchesAlpha(string $expected, ?int $length)
    {
        $generator = $this->getRandomGenerator($length, RandomGenerator::STRATEGY_ALPHA);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaData(): \Generator
    {
        yield ['/^[a-zA-Z]+/', null];
        yield ['/^[a-zA-Z]+/', 10];
        yield ['/^[a-zA-Z]+/', 32];
        yield ['/^[a-zA-Z]+/', 40];
        yield ['/^[a-zA-Z]+/', 64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthAlphaData
     */
    public function testGenerateFromGivenLengthAlpha(int $expected, ?int $length)
    {
        $generator = $this->getRandomGenerator($length, RandomGenerator::STRATEGY_ALPHA);
        $actual = $generator->generate();

        $this->assertLength($length ?? RandomGenerator::DEFAULT_LENGTH, $actual);
    }

    public function provideGenerateFromGivenLengthAlphaData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    /**
     * @dataProvider provideGenerateFromMatchesNumericData
     */
    public function testGenerateFromMatchesNumeric(string $expected, ?int $length)
    {
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_NUMERIC)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_NUMERIC);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesNumericData(): \Generator
    {
        yield ['/^[0-9]+/', null];
        yield ['/^[0-9]+/', 10];
        yield ['/^[0-9]+/', 32];
        yield ['/^[0-9]+/', 40];
        yield ['/^[0-9]+/', 64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthNumericData
     */
    public function testGenerateFromGivenLengthNumeric(int $expected, ?int $length)
    {
        $generator = $this->getRandomGenerator($length, RandomGenerator::STRATEGY_NUMERIC);
        $actual = $generator->generate();

        $this->assertLength($length ?? RandomGenerator::DEFAULT_LENGTH, $actual);
    }

    public function provideGenerateFromGivenLengthNumericData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    /**
     * @dataProvider provideGenerateFromMatchesAlphaNumericData
     */
    public function testGenerateFromMatchesAlphaNumeric(string $expected, ?int $length)
    {
        $generator = $length ? new RandomGenerator($length) : new RandomGenerator();
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaNumericData(): \Generator
    {
        yield ['/^[a-zA-Z0-9]+/', null];
        yield ['/^[a-zA-Z0-9]+/', 10];
        yield ['/^[a-zA-Z0-9]+/', 32];
        yield ['/^[a-zA-Z0-9]+/', 40];
        yield ['/^[a-zA-Z0-9]+/', 64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthAlphaNumericData
     */
    public function testGenerateFromGivenLengthAlphaNumeric(int|string $expected, ?int $length)
    {
        $generator = $length ? new RandomGenerator($length) : new RandomGenerator();
        $actual = $generator->generate();

        $this->assertLength($expected, $actual);
    }

    public function provideGenerateFromGivenLengthAlphaNumericData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    private static function assertLength($excepted, $actual, $message = ''): void
    {
        self::assertEquals($excepted, strlen($actual), $message);
    }

    private function getRandomGenerator(?int $length, ?string $strategy): RandomGenerator
    {
        $length = $length ?? RandomGenerator::DEFAULT_LENGTH;

        return $strategy ? new RandomGenerator($length, $strategy) : new RandomGenerator($length);
    }
}
