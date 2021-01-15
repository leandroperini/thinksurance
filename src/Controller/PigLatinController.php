<?php

namespace App\Controller;

use App\Services\PigLatin\PigLatinService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/pig-latin", name="pig_latin_")
 */
class PigLatinController extends AbstractController
{
    /**
     * @Route("/{word}", name="analyze", methods={"GET"})
     * @param string                                      $word
     * @param \App\Services\PigLatin\PigLatinService|null $PigLatinService
     *
     * @return string
     */
    public function analyzeWord(string $word = '', PigLatinService $PigLatinService = null) {
        if (empty($word)) {
            return new Response('A word must be informed in the url, such as "<a href="/pig-latin/example">/pig-latin/example"</a>');
        }

        $response = "The word '$word' is PigLatin.";
        if (!$PigLatinService->isPigLatin($word)) {
            $response = "The word '$word' is not PigLatin, it would be: " . $PigLatinService->convert($word);
        }

        return new Response($response);
    }

    /**
     * @Route("/convert/{word}", name="convert", methods={"GET"})
     * @param string                                      $word
     * @param \App\Services\PigLatin\PigLatinService|null $PigLatinService
     *
     * @return string
     */
    public function convertToPigLatin(string $word = '', PigLatinService $PigLatinService = null) {
        if (empty($word)) {
            return new Response('A word must be informed in the url, such as "<a href="/pig-latin/convert/example">/pig-latin/convert/example"</a>');
        }
        $response = "The word '$word' already is PigLatin.";
        if (!$PigLatinService->isPigLatin($word)) {
            $response = "The word '$word' in PigLatin is: " . $PigLatinService->convert($word);
        }
        return new Response($response);
    }

    /**
     * @Route("/check/{word}", name="check", methods={"GET"})
     * @param string                                      $word
     * @param \App\Services\PigLatin\PigLatinService|null $PigLatinService
     *
     * @return string
     */
    public function chekIfPigLatin(string $word = '', PigLatinService $PigLatinService = null) {
        if (empty($word)) {
            return new Response('A word must be informed in the url, such as "<a href="/pig-latin/check/example">/pig-latin/check/example"</a>');
        }

        $response = "The word '$word' is PigLatin.";
        if (!$PigLatinService->isPigLatin($word)) {
            $response = "The word '$word' is not PigLatin";
        }

        return new Response($response);
    }
}
