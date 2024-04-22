<?php

namespace App\CurrencyConversion\Service\SourcesCurrencies\Exception;

use Exception;

class UnknownCurrencyException extends Exception
{
    protected $message = 'Неизвестная для системы валюта.';
}