<?php

namespace App\Contracts\Exchange;


use App\Enums\Exchange\RateApiTypes;
use App\Contracts\ServiceInterface;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * -note: This interface mau not make sense now, it's here for a future safeness
 * Interface ExchangeServiceInterface
 *
 * @package App\Contracts\Exchange
 */
interface ExchangeServiceInterface extends ServiceInterface
{
    /**
     * ExchangeService constructor.
     *
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     * @param \Psr\Log\LoggerInterface                          $logger
     */
    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger);

    /**
     * @param string $date
     *
     * @return \DateTime|false
     */
    public function parseDateFilter(string $date);

    /**
     * @param \App\Enums\Exchange\RateApiTypes $mode
     * @param iterable                         $params
     * @param \DateTime|null                   $date
     *
     * @return bool|array
     */
    public function getRatesFromApi(RateApiTypes $mode, iterable $params = [], DateTime $date = null);
}