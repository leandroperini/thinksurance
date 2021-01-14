<?php


namespace App\Services\Exchange;

use App\Enums\Exchange\RateApiTypes;
use App\Contracts\Exchange\ExchangeServiceInterface;
use DateTime;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;
use function Symfony\Component\String\u;

class ExchangeService implements ExchangeServiceInterface
{
    /**
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $httpClient;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * ExchangeService constructor.
     *
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     * @param \Psr\Log\LoggerInterface                          $logger
     */
    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger) {
        $this->httpClient = $httpClient;
        $this->logger     = $logger;
    }


    /**
     * @param string $date
     *
     * @return \DateTime|false
     */
    public function parseDateFilter(string $date) {
        $date = (new AsciiSlugger())->slug($date);
        [
            $year,
            $month,
            $day,
        ] = u($date)->split('-');

        if (!checkdate($month->toString(), $day->toString(), $year->toString())) {
            throw new BadRequestException('Informed date is invalid.', 422);
        }

        return $date = DateTime::createFromFormat("Y-m-d", $date, new \DateTimeZone('UTC'));
    }

    /**
     * @param \App\Enums\Exchange\RateApiTypes $mode
     * @param iterable                         $params
     * @param \DateTime|null                   $date
     *
     * @return bool|array
     */
    public function getRatesFromApi(RateApiTypes $mode, iterable $params = [], DateTime $date = null) {

        try {
            $filter = $mode->getValue();
            if ($filter == RateApiTypes::BY_DATE) {
                $filter = $date->format('Y-m-d');
            }

            $response = $this->httpClient->request(
                'GET',
                "https://api.exchangeratesapi.io/$filter",
                [
                    'query' => $params,
                ]
            );
            return $response->toArray(false);
        } catch (\Throwable $t) {
            $this->logger->warning('Error when getting data from API: ' . $t->getMessage());
            return false;
        }
    }
}