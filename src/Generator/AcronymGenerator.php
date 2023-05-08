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

        $acronym = '';
        foreach ($words as $word) {
            $firstChar = $this->getFirstAlphaNumericCharacter($word);
            $firstChar = $this->convertToSpecialCharacter($firstChar);

            $acronym .= $firstChar;
        }

        // add emoticons
        //$acronym .= ':)';

        return $acronym; // I go bowling every Friday night with 8 friends becomes 1gbeFnw8f:)
    }

    private function validatePhrase(string $phrase): void
    {
        if (empty($phrase)) {
            throw new \InvalidArgumentException('Phrase cannot be empty');
        }

        if ($this->isHtml($phrase)) {
            throw new \InvalidArgumentException('Phrase should be contains alpha numeric chars and symbols');
        }
    }

    private function isHtml(string $phrase): bool
    {
        return preg_match("/<[^<]+>/", $phrase) !== 0;
    }

    private function splitPhraseIntoWords(string $phrase): array
    {
        return preg_split('/\s+/', trim($phrase));
    }

    private function getFirstAlphaNumericCharacter(mixed $word): ?string
    {
        $firstChar = null;

        for ($i = 0; $i < strlen($word); $i++) {
            $char = substr($word, $i, 1);
            if (ctype_alnum($char)) {
                $firstChar = $char;
                break;
            }
        }

        return $firstChar;
    }

    private function convertToSpecialCharacter(?string $firstChar): string|array
    {
        // A a B b C c D d E e F f G g H h I i J j K k L l M m N n O o P p Q q R r S s T t U u V v W w X x Y y Z z
        return str_ireplace(['a', 'e', 'i', 'l', 'o', 's'], ['@', '3', '!', '1', '0', '5'], $firstChar);
    }
}