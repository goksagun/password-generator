<?php

namespace App\Tests\Generator;

use App\Generator\GeneratorInterface;
use App\Generator\PasswordGenerator;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorTest extends TestCase
{
    private readonly GeneratorInterface $generator;

    protected function setUp(): void
    {
        $this->generator = new PasswordGenerator();
    }

    /**
     * @dataProvider provideGenerateFromData
     */
    public function testGenerateFrom(string $expected, string $input): void
    {
        $actual = $this->generator->generateFrom($input);

        $this->assertEquals(expected: $expected, actual: $actual);
    }

    public function provideGenerateFromData(): \Generator
    {
        yield ['!gb3Fnw8f', 'I go bowling every Friday night with 8 friends'];
        yield ['!wb!NY0@h5d0J6', 'I was born in New York on a hot summer day on June 6'];
        yield ['31tw5td0d', 'Every living thing will surely taste death one day.'];
        yield ['B3gmt@gw', 'Behind every great man there\'s a great woman'];
        yield ['Bth1@1tnth1@@', 'Better to have loved and lost than never to have loved at all'];
        yield ['G!0p!@9pp', 'Genius is one percent inspiration and 99 percent perspiration'];
        yield ['Md@3g0!tm5', 'Mad dogs and Englishmen go out in the midday sun'];
        yield ['55nbt3', ' Space should not be throw error '];
        yield ['15nbt3', "\r\nLinefeed should not be throw error \r\n"];
    }

    public function testThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->generator->generateFrom('<p>I go bowling every Friday night with 8 friends</p>');
    }


}
