<?php

namespace App\Tests\Generator;

use App\Generator\RandomGenerator;
use PHPUnit\Framework\TestCase;

class RandomGeneratorTest extends TestCase
{

    /**
     * @dataProvider provideGenerateFromMatchesAlphaData
     */
    public function testGenerateFromMatchesAlpha(?int $length): void
    {
        $expected = '/^[a-zA-Z]+$/';
        $generator = $this->getRandomGenerator($length, RandomGenerator::STRATEGY_ALPHA);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaData(): \Generator
    {
        yield [null];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthAlphaData
     */
    public function testGenerateFromGivenLengthAlpha(int $expected, ?int $length): void
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
    public function testGenerateFromMatchesNumeric(?int $length): void
    {
        $expected = '/^[0-9]+$/';
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_NUMERIC)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_NUMERIC);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesNumericData(): \Generator
    {
        yield [null];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthNumericData
     */
    public function testGenerateFromGivenLengthNumeric(int $expected, ?int $length): void
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
    public function testGenerateFromMatchesAlphaNumeric(?int $length): void
    {
        $expected = '/^[a-zA-Z0-9]+$/';
        $generator = $length ? new RandomGenerator($length) : new RandomGenerator();
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaNumericData(): \Generator
    {
        yield [null];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthAlphaNumericData
     */
    public function testGenerateFromGivenLengthAlphaNumeric(int|string $expected, ?int $length): void
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

    /**
     * @dataProvider provideGenerateFromMatchesComplexData
     */
    public function testGenerateFromMatchesComplex(?int $length): void
    {
        $expected = '/^[a-zA-Z0-9\]\[}{@_!#$%^&*()<>?|~:;=\-+]+$/';

        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_COMPLEX)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_COMPLEX);
        $actual = $generator->generate();


        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesComplexData(): \Generator
    {
        yield [null,];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthMatchesComplexData
     */
    public function testGenerateFromGivenLengthMatchesComplex(int $expected, ?int $length): void
    {
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_COMPLEX)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_COMPLEX);
        $actual = $generator->generate();

        $this->assertLength($expected, $actual);
    }

    public function provideGenerateFromGivenLengthMatchesComplexData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    /**
     * @dataProvider provideGenerateFromMatchesAlphaLowerData
     */
    public function testGenerateFromMatchesAlphaLower(?int $length): void
    {
        $expected = '/^[a-z]+$/';
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHA_LOWER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHA_LOWER);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaLowerData(): \Generator
    {
        yield [null,];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthMatchesAlphaLowerData
     */
    public function testGenerateFromGivenLengthMatchesAlphaLower(int $expected, ?int $length): void
    {
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHA_LOWER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHA_LOWER);
        $actual = $generator->generate();

        $this->assertLength($expected, $actual);
    }

    public function provideGenerateFromGivenLengthMatchesAlphaLowerData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    /**
     * @dataProvider provideGenerateFromMatchesAlphaUpperData
     */
    public function testGenerateFromMatchesAlphaUpper(?int $length): void
    {
        $expected = '/^[A-Z]+$/';
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHA_UPPER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHA_UPPER);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaUpperData(): \Generator
    {
        yield [null,];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthMatchesAlphaUpperData
     */
    public function testGenerateFromGivenLengthMatchesAlphaUpper(int $expected, ?int $length): void
    {
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHA_UPPER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHA_UPPER);
        $actual = $generator->generate();

        $this->assertLength($expected, $actual);
    }

    public function provideGenerateFromGivenLengthMatchesAlphaUpperData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    /**
     * @dataProvider provideGenerateFromMatchesAlphaNumericLowerData
     */
    public function testGenerateFromMatchesAlphaNumericLower(?int $length): void
    {
        $expected = '/^[a-zA-Z0-9]+$/';
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHANUMERIC_LOWER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHANUMERIC_LOWER);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaNumericLowerData(): \Generator
    {
        yield [null,];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthMatchesAlphaNumericLowerData
     */
    public function testGenerateFromGivenLengthMatchesAlphaNumericLower(int $expected, ?int $length): void
    {
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHANUMERIC_LOWER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHANUMERIC_LOWER);
        $actual = $generator->generate();

        $this->assertLength($expected, $actual);
    }

    public function provideGenerateFromGivenLengthMatchesAlphaNumericLowerData(): \Generator
    {
        yield [8, null];
        yield [10, 10];
        yield [32, 32];
        yield [40, 40];
        yield [64, 64];
    }

    /**
     * @dataProvider provideGenerateFromMatchesAlphaNumericUpperData
     */
    public function testGenerateFromMatchesAlphaNumericUpper(?int $length): void
    {
        $expected = '/^[A-Z0-9]+$/';
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHANUMERIC_UPPER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHANUMERIC_UPPER);
        $actual = $generator->generate();

        $this->assertMatchesRegularExpression($expected, $actual);
    }

    public function provideGenerateFromMatchesAlphaNumericUpperData(): \Generator
    {
        yield [null,];
        yield [10];
        yield [32];
        yield [40];
        yield [64];
    }

    /**
     * @dataProvider provideGenerateFromGivenLengthMatchesAlphaNumericUpperData
     */
    public function testGenerateFromGivenLengthMatchesAlphaNumericUpper(int $expected, ?int $length): void
    {
        $generator = $length
            ? new RandomGenerator($length, RandomGenerator::STRATEGY_ALPHANUMERIC_UPPER)
            : new RandomGenerator(strategy: RandomGenerator::STRATEGY_ALPHANUMERIC_UPPER);
        $actual = $generator->generate();

        $this->assertLength($expected, $actual);
    }

    public function provideGenerateFromGivenLengthMatchesAlphaNumericUpperData(): \Generator
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
