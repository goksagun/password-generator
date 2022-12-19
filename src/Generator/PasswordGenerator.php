<?php

namespace App\Generator;

class PasswordGenerator implements GeneratorInterface
{
    public function generateFrom(string $phrase): string
    {
        $this->validate($phrase);

        $phrase = $this->cleanup($phrase);

        $words = $this->splitToWords($phrase);

        $acronymList = $this->createAcronymListFrom($words);

        return $this->concat($acronymList);
    }

    private function validate(string $phrase): void
    {
        if ($this->isHtml($phrase)) {
            throw new PhraseNotValidException('Phrase must be contains alpha numeric chars and symbols');
        }
    }

    private function isHtml(string $phrase): bool
    {
        return preg_match("/<[^<]+>/", $phrase) !== 0;
    }

    private function cleanup(string $phrase): string
    {
        return trim($phrase);
    }

    private function splitToWords(string $phrase): array
    {
        return explode(' ', $phrase);
    }

    private function createAcronymListFrom(array $words): array
    {
        $listAcronym = [];
        foreach ($words as $word) {
            // take first char every word in text
            $firstChar = $word[0];

            // skip if not alphanumeric
            if (!ctype_alnum($firstChar)) {
                continue;
            }

            $listAcronym[] = $this->convertToNumeralAndSpecialChar($firstChar);
        }
        return $listAcronym;
    }

    private function concat(array $acronymList): string
    {
        return implode('', $acronymList);
    }

    private function convertToNumeralAndSpecialChar(mixed $char): string|array
    {
        // A a B b C c D d E e F f G g H h I i J j K k L l M m N n O o P p Q q R r S s T t U u V v W w X x Y y Z z
        return str_ireplace(
            ['a', 'e', 'i', 'l', 'o', 's'],
            ['@', '3', '!', '1', '0', '5'],
            $char
        );
    }
}
