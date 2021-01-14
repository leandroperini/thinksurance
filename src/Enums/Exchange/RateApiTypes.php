<?php


namespace App\Enums\Exchange;


use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;

final class RateApiTypes extends Enum
{
    use AutoDiscoveredValuesTrait;

    public const BY_DATE      = 'by_date';
    public const FROM_HISTORY = 'history';
    public const LATEST       = 'latest';
}