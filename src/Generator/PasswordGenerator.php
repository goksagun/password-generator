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
            throw new PhraseNotValidException('The phrase must contain alphanumeric characters and symbols');
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
            $firstChar = $this->getFirstChar($word);

            if (!$this->isAlphanumeric($firstChar)) {
                continue;
            }

            $listAcronym[] = $this->convertToNumeralAndSpecialChar($firstChar);
        }
        return $listAcronym;
    }

    private function getFirstChar($word)
    {
        return $word[0];
    }

    private function isAlphanumeric(mixed $firstChar): bool
    {
        return ctype_alnum($firstChar);
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

    private function concat(array $acronymList): string
    {
        return implode('', $acronymList);
    }
}
