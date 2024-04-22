<?php

namespace App\CurrencyConversion\Service\Conversion\Exception;

use Exception;

class UnknownCurrencyRatioException extends Exception
{
    protected $message = 'Неизвестное соотношение валют.';
}