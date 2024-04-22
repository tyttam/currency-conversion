<?php

namespace App\CurrencyConversion\Service\SourcesCurrencies\Dto;

use DateTimeImmutable;

class LatestCurrencyDto
{
    /**
     * Время запроса валют
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $currentTime;

    /**
     * Список валют и их коэффициент по отношению к выбранной валюте
     *
     * @var array
     */
    private array $currentListConversion;

    /**
     * Валюта, которую хотят конвертировать
     *
     * @var string
     */
    private string $currentCurrency;

    /**
     * @return DateTimeImmutable
     */
    public function getCurrentTime(): DateTimeImmutable
    {
        return $this->currentTime;
    }

    /**
     * @param DateTimeImmutable $currentTime
     * @return LatestCurrencyDto
     */
    public function setCurrentTime(DateTimeImmutable $currentTime): self
    {
        $this->currentTime = $currentTime;
        return $this;
    }

    /**
     * @return array
     */
    public function getCurrentListConversion(): array
    {
        return $this->currentListConversion;
    }

    /**
     * @param array $currentListConversion
     * @return LatestCurrencyDto
     */
    public function setCurrentListConversion(array $currentListConversion): self
    {
        $this->currentListConversion = $currentListConversion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentCurrency(): string
    {
        return $this->currentCurrency;
    }

    /**
     * @param string $currentCurrency
     * @return LatestCurrencyDto
     */
    public function setCurrentCurrency(string $currentCurrency): self
    {
        $this->currentCurrency = $currentCurrency;
        return $this;
    }
}