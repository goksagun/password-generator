<?php

namespace App\Generator;

class PasswordGenerator implements GeneratorInterface
{
    public function generateFrom(string $phrase): string
    {
        $this->validate($phrase);

        $phrase = $this->cleanup($phrase);

        $words = $this->splitPhraseToWords($phrase);

        $listAcronym = $this->getListAcronym($words);

        // concat list as a text
        $acronym = implode(separator: '', array: $listAcronym);

        // add emoticons
        //$acronym .= ':)';

        return $acronym; // I go bowling every Friday night with 8 friends becomes 1gbeFnw8f:)
    }

    private function isHtml(string $phrase): bool
    {
        return preg_match("/<[^<]+>/", $phrase) !== 0;
    }

    private function validate(string $phrase): void
    {
        if ($this->isHtml($phrase)) {
            throw new \InvalidArgumentException('Phrase must be contains alpha numeric chars and symbols');
        }
    }

    private function cleanup(string $phrase): string
    {
        return trim($phrase);
    }

    private function splitPhraseToWords(string $phrase): array
    {
        return explode(' ', $phrase);
    }

    private function getListAcronym(array $words): array
    {
        $listAcronym = [];
        foreach ($words as $word) {
            // take first char every word in text
            $firstChar = $word[0];

            // skip if not alphanumeric
            if (!ctype_alnum($firstChar)) {
                continue;
            }

            // convert to numeral
            // A a B b C c D d E e F f G g H h I i J j K k L l M m N n O o P p Q q R r S s T t U u V v W w X x Y y Z z
            $firstChar = str_ireplace(['a', 'e', 'i', 'l', 'o', 's'], ['@', '3', '!', '1', '0', '5'], $firstChar);

            $listAcronym[] = $firstChar;
        }
        return $listAcronym;
    }
}