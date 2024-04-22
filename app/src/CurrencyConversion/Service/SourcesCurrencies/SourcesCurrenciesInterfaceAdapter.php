<?php

namespace App\CurrencyConversion\Service\SourcesCurrencies;

use App\CurrencyConversion\Service\SourcesCurrencies\Dto\LatestCurrencyDto;

interface SourcesCurrenciesInterfaceAdapter
{
    /**
     * Метод возвращает коэффициент по отношению к выбранной валюте
     *
     * @param string $conversionCurrency
     * @return LatestCurrencyDto
     */
    public function getLatest(string $conversionCurrency): LatestCurrencyDto;
}