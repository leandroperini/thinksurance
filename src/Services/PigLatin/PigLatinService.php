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

    /**
     * Converts string to pigLatin, if the string is already a pigLatin
     * then it returns the same string
     *
     * @param string $word
     *
     * @return string
     */
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

    /**
     * Parser to detect which parts of the string should be considered
     * for the pigLatin translation
     *
     * @param string $word
     *
     * @return array|string[]
     */
    private function detectWordParts(string $word) : array {
        if ($fromCache = $this->getFromCache($word)) {
            return $fromCache;
        }

        $letters  = str_split($word);
        $wordSize = strlen($word);

        /**
         * -note: here it's a very unusual and handy trick that allows a better readability
         *       and it's easier to change and grow, it works just like an ifElse:
         * if($this->isVowel($word[0])){
         * }elseif(strtolower($word[-1]) == 'y' and $wordSize == 2){
         * }
         *
         *  Skips some very known situations to reduce computational resources usage
         */
        switch (true) {
            // when first letter is vowel
            case $this->isVowel($word[0]):
                return [
                    'y',
                    $word,
                ];
            // when the word is something like my and by
            case $this->isTwoLetterWordEndingWithY($word):
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
                // the substr is getting the rest of the letters that came after last consonant
                $secondPart = substr($word, $index - $wordSize);
                break;
            }
        }

        return $this->setCache($word, [
            $firstPart,
            $secondPart,
        ]);
    }

    /**
     * Checks if the word is a pigLatin of a pigLatin, if this is the case
     * then the original word was already in pigLatin
     *
     * @param string $word
     *
     * @return bool
     */
    public function isPigLatin(string $word) : bool {
        return preg_match('/^[aeiouy][a-z]+(?:ay)(?<!(ayyay))$/i', $word) == 1;
    }

    private function isConsonant($letter) : bool {
        return (bool)($this->consonants[strtoupper($letter)] ?? false);
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

    private function isTwoLetterWordEndingWithY(string $word) {
        return strtolower($word[-1]) == 'y' and strlen($word) == 2;
    }

}