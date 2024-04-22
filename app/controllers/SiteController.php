<?php

namespace app\controllers;

use App\CurrencyConversion\Service\Conversion\CurrencyConversionService;
use App\CurrencyConversion\Service\Conversion\Enum\CurrentCurrenciesEnum;
use App\CurrencyConversion\Service\SourcesCurrencies\Adapter\OpenExchangeRatesAdapter;
use GuzzleHttp\Client;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        try {
            $client = new Client();
            $openExchangeRatesAdapter = new OpenExchangeRatesAdapter($client);
            $currencyConversionService = new CurrencyConversionService($openExchangeRatesAdapter);
            $results = $currencyConversionService->getCurrentCurrencyValue(CurrentCurrenciesEnum::USD, CurrentCurrenciesEnum::RUB);
        } catch (\Throwable $exception) {
            $results = $exception->getMessage();
        }
        return $this->render('index', ['data' => $results]);
    }
}
