<?php

namespace App\CurrencyConversion\Service\Conversion;

use App\CurrencyConversion\Service\Conversion\Exception\UnknownCurrencyRatioException;
use App\CurrencyConversion\Service\SourcesCurrencies\SourcesCurrenciesInterfaceAdapter;

class CurrencyConversionService
{
    public function __construct(private readonly SourcesCurrenciesInterfaceAdapter $sourcesCurrencies) {}

    /**
     * Возвращает коэффициент запрашиваемой валюты по отношению к другой
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int|float
     * @throws UnknownCurrencyRatioException
     */
    public function getCurrentCurrencyValue(string $fromCurrency, string $toCurrency): int|float
    {
        $latestCurrency = $this->sourcesCurrencies->getLatest($fromCurrency);
        $latestCurrencyListConversion = $latestCurrency->getCurrentListConversion();
        $latestCurrencyConversionCoefficient = $latestCurrencyListConversion[$toCurrency] ?? 0;

        if ($latestCurrencyConversionCoefficient <= 0) {
            throw new UnknownCurrencyRatioException();
        }
        return $latestCurrencyConversionCoefficient;
    }
}