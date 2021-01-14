<?php

namespace App\Controller;

use App\Enums\Exchange\RateApiTypes;
use App\Contracts\Exchange\ExchangeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/exchange", methods={"GET"}, name="exchange_")
 */
class ExchangeController extends AbstractController
{
    /**
     * @var \App\Contracts\Exchange\ExchangeServiceInterface
     */
    private $ExchangeSrvc;

    /**
     * ExchangeController constructor.
     *
     * @param \App\Contracts\Exchange\ExchangeServiceInterface $exchangeService
     */
    public function __construct(ExchangeServiceInterface $exchangeService) {
        $this->ExchangeSrvc = $exchangeService;
    }


    /**
     * @Route("/rates/{date<[0-9]{4}(?:-[0-9]{1,2}){2}>?}", name="rates_by_date", stateless=true)
     * @param string $date
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ratesByDate(string $date) : Response {
        try {
            $date = $this->ExchangeSrvc->parseDateFilter($date);
        } catch (\Throwable $t) {
            return $this->render('exchange/rates.html.twig', [
                'number' => $t->getMessage(),
            ]);
        }
        $params  = $this->extractQueryStrings();
        $apiType = RateApiTypes::get(RateApiTypes::BY_DATE);
        $rates   = $this->ExchangeSrvc->getRatesFromApi($apiType, $params, $date);
        return $this->render('exchange/rates.html.twig', $this->prepareVariablesToRender($rates, $apiType));
    }


    /**
     * @Route("/rates/latest", name="rates_latest", priority=3)
     */
    public function ratesLatest() : Response {
        $params  = $this->extractQueryStrings();
        $apiType = RateApiTypes::get(RateApiTypes::LATEST);
        $rates   = $this->ExchangeSrvc->getRatesFromApi($apiType, $params);
        return $this->render('exchange/rates.html.twig', $this->prepareVariablesToRender($rates, $apiType));
    }

    /**
     * @Route("/rates/history", name="rates_from_history", priority=2, stateless=true)
     */
    public function ratesFromHistory() : Response {
        $params  = $this->extractQueryStrings();
        $apiType = RateApiTypes::get(RateApiTypes::FROM_HISTORY);
        $rates   = $this->ExchangeSrvc->getRatesFromApi($apiType, $params);
        return $this->render('exchange/ratesHistory.html.twig', $this->prepareVariablesToRender($rates, $apiType));
    }

    private function prepareVariablesToRender(iterable $rates, RateApiTypes $apiType) : array {
        $variables = [
            'rates'      => $rates['rates'] ?? [],
            'base'       => $rates['base'] ?? '',
            'date'       => $rates['date'] ?? '',
            'dateCounts' => 0,
            'error'      => false,
        ];

        if (isset($rates['error'])) {
            $variables['error'] = $rates['error'];
            return $variables;
        }

        switch ($apiType->getValue()) {
            case RateApiTypes::BY_DATE:
            case RateApiTypes::LATEST:
                $variables['date'] = (new \DateTime($rates['date']))->format('m/d/Y');
                break;
            case RateApiTypes::FROM_HISTORY:
                $variables['date']       = (new \DateTime($rates['start_at']))->format('m/d/Y') . '->' . (new \DateTime($rates['end_at']))->format('m/d/Y');
                $variables['dateCounts'] = $this->getCurrencyCountPerDay($rates['rates']);
                break;
        }

        return $variables;
    }

    private function getCurrencyCountPerDay(iterable $rates) {
        $counts = [];
        foreach ($rates as $date => $dateRates) {
            $counts[$date] = count($dateRates);
        }
        return $counts;
    }

    private function extractQueryStrings() {
        $request = Request::createFromGlobals();
        return $request->query->all();
    }
}
