<?php

namespace App\Utils;

final class StringUtils
{
    public function __construct()
    {
        throw new \Exception('This is a utility class and cannot be instantiated');
    }

    /**
     * Linefeed means to advance downward to the next line; however, it has been repurposed and renamed.
     * Used as "newline", it terminates lines (commonly confused with separating lines).
     * This is commonly escaped as "\n", abbreviated LF or NL, and has ASCII value 10 or 0xA.
     * CRLF (but not CRNL) is used for the pair "\r\n".
     */
    public static function removeLineFeed(string $query): string
    {
        return preg_replace('/(\r\n|\r|\n)/', '', $query);
    }
}