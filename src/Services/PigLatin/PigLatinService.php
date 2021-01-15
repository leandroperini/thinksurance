<?php

namespace App\Services\PigLatin;

use App\Contracts\ServiceInterface;
use function Symfony\Component\String\u;

class PigLatinService implements ServiceInterface
{
    private array $consonants = [
        'B' => true,
        'C' => true,
        'D' => true,
        'F' => true,
        'G' => true,
        'H' => true,
        'J' => true,
        'K' => true,
        'L' => true,
        'M' => true,
        'N' => true,
        'P' => true,
        'Q' => true,
        'R' => true,
        'S' => true,
        'T' => true,
        'V' => true,
        'W' => true,
        'X' => true,
        'Y' => true,
        'Z' => true,
    ];
    private array $vowels     = [
        'A' => true,
        'E' => true,
        'I' => true,
        'O' => true,
        'U' => true,
    ];

    private array $convertedCache = [];

    public function convert(string $word) : string {
        if ($this->isPigLatin($word)) {
            return $word;
        }
        [
            $firstPart,
            $secondPart,
        ] = $this->detectWordParts($word);
        return $secondPart . $firstPart . 'ay';
    }

    private function detectWordParts(string $word) : array {
        if ($fromCache = $this->getFromCache($word)) {
            return $fromCache;
        }

        $letters  = str_split($word);
        $wordSize = strlen($word);

        switch (true) {
            case $this->isVowel($word[0]):
                return [
                    'y',
                    $word,
                ];
            case strtolower($word[-1]) == 'y' and $wordSize == 2:
                return [
                    rtrim($word, 'y'),
                    'y',
                ];
        }

        $firstPart  = '';
        $secondPart = '';
        foreach ($letters as $index => $letter) {
            if ($this->isConsonant($letter)) {
                $firstPart .= $letter;
                continue;
            }

            if ($this->isVowel($letter)) {
                $secondPart = substr($word, $index - $wordSize);
                break;
            }
        }

        return $this->setCache($word, [
            $firstPart,
            $secondPart,
        ]);
    }

    public function isPigLatin(string $word) : bool {
        return preg_match('/^[aeiouy][a-z]+(?:ay)(?<!(ayyay))$/i', $word) == 1;
    }

    private function isConsonant($letter) : bool {
        return (bool)($this->consonants[strtoupper($letter)] ?? false);
    }

    private function IsYAVowel(string $letterPrecedingY) {
        return empty($letterPrecedingY) or $this->isConsonant($letterPrecedingY);
    }

    private function isVowel($letter) : bool {
        return (bool)($this->vowels[strtoupper($letter)] ?? false);
    }

    private function getFromCache(string $word) {
        return $this->convertedCache[$word] ?? false;
    }

    private function setCache($index, $value) {
        return $this->convertedCache[$index] = $value;
    }

}