<?php

namespace App\Generator;

class AcronymGenerator implements GeneratorInterface
{

    private const SPECIAL_CHARACTER_MAP = [
        'a' => '@',
        'e' => '3',
        'i' => '!',
        'l' => '1',
        'o' => '0',
        's' => '5',
    ];

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

        return $this->getAcronym($words);
    }

    private function validatePhrase(string $phrase): void
    {
        $phrase = $this->removeSpecialChars($phrase);

        $phrase = $this->removeHtmlTags($phrase);

        if (empty($phrase)) {
            throw new \InvalidArgumentException('Phrase cannot be empty');
        }
    }

    private function removeSpecialChars(string $phrase): string|array|null
    {
        return preg_replace('/[\'^£$%&*()}{@#~?><>.,|=_+¬-]/', '', $phrase);
    }

    private function removeHtmlTags(string $phrase): string
    {
        return strip_tags($phrase);
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

    private function convertToSpecialCharacter(?string $char): string
    {
        return self::SPECIAL_CHARACTER_MAP[strtolower($char)] ?? $char;
    }

    private function getAcronym(array $words): string
    {
        $acronym = '';
        foreach ($words as $word) {
            $acronym .= $this->convertToSpecialCharacter(
                $this->getFirstAlphaNumericCharacter($word)
            );
        }

        return $acronym;
    }
}