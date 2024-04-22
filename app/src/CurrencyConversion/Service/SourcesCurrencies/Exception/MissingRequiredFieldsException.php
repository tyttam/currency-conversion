<?php

namespace App\CurrencyConversion\Service\SourcesCurrencies\Exception;

use Exception;

class MissingRequiredFieldsException extends Exception
{
    protected $message = 'Отсутствуют обязательные поля конвертации валюты.';
}