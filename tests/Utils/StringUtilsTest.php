<?php

namespace App\Tests\Utils;

use App\Utils\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{

    public function test_string_utility_class_should_not_instantiate()
    {
        $this->expectException(\Exception::class);

        new StringUtils();
    }

    /**
     * @dataProvider provideRemoveFeedLineData
     */
    public function testRemoveFeedLine(string $expected, string $input)
    {
        $this->assertEquals($expected, StringUtils::removeLineFeed($input));
    }

    public function provideRemoveFeedLineData(): \Generator
    {
        yield ['Hello World', "Hello World"];
        yield ['Hello World', "Hello World\n"];
        yield ['Hello World', "Hello World\r"];
        yield ['Hello World', "Hello World\r\n"];
    }
}
