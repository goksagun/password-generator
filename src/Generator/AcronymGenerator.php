<?php

namespace App\Generator;

class AcronymGenerator implements GeneratorInterface
{

    public function __construct(private readonly string $phrase)
    {
    }

    public function generate(): string
    {
        return $this->generateAcronymFromPhrase($this->phrase);
    }

    private function generateAcronymFromPhrase(string $phrase): string
    {
        $this->validatePhrase($phrase);

        $words = $this->splitPhraseIntoWords($phrase);

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

        // concat list as a text
        $acronym = implode(separator: '', array: $listAcronym);

        // add emoticons
        //$acronym .= ':)';

        return $acronym; // I go bowling every Friday night with 8 friends becomes 1gbeFnw8f:)
    }

    private function is_html(string $phrase): bool
    {
        return preg_match("/<[^<]+>/", $phrase) !== 0;
    }

    private function validatePhrase(string $phrase): void
    {
        if ($this->is_html($phrase)) {
            throw new \InvalidArgumentException('Phrase must be contains alpha numeric chars and symbols');
        }
    }

    private function splitPhraseIntoWords(string $phrase): array
    {
        return preg_split('/\s+/', trim($phrase));
    }
}