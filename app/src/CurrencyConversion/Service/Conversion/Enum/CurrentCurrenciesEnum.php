<?php

namespace App\CurrencyConversion\Service\Conversion\Enum;

/**
 * Список актуальных валют в системе
 */
interface CurrentCurrenciesEnum
{
    public const RUB = 'RUB';
    public const USD = 'USD';
    public const EUR = 'EUR';
    public const BTC = 'BTC';

    public const LIST = [
        self::EUR,
        self::USD,
        self::RUB,
        self::BTC,
    ];
}