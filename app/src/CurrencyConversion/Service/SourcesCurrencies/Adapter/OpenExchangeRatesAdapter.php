<?php

namespace App\CurrencyConversion\Service\SourcesCurrencies\Adapter;

use App\CurrencyConversion\Service\Conversion\Enum\CurrentCurrenciesEnum;
use App\CurrencyConversion\Service\SourcesCurrencies\Dto\LatestCurrencyDto;
use App\CurrencyConversion\Service\SourcesCurrencies\Exception\MissingRequiredFieldsException;
use App\CurrencyConversion\Service\SourcesCurrencies\Exception\UnknownCurrencyException;
use App\CurrencyConversion\Service\SourcesCurrencies\SourcesCurrenciesInterfaceAdapter;
use GuzzleHttp\Client;
use Yii;
use yii\caching\CacheInterface;

class OpenExchangeRatesAdapter implements SourcesCurrenciesInterfaceAdapter
{
    private string $urlApi;
    private string $appId;
    private string $cachePrefixApiService;
    private CacheInterface $cache;

    public function __construct(private readonly Client $httpClient)
    {
        /** По-хорошему нужно добавить DI контейнер и все это там передать */
        $this->urlApi = getenv('OPEN_EXCHANGE_RATES_URL');
        $this->appId = getenv('OPEN_EXCHANGE_RATES_APP_ID');
        $this->cachePrefixApiService = getenv('OPEN_EXCHANGE_RATES_CACHE_PREFIX');
        $this->cache = Yii::$app->cache;
    }

    /**
     * @inheritDoc
     *
     * @param string $conversionCurrency !!! Нужен платный тариф для смены валюты
     * @return LatestCurrencyDto
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws MissingRequiredFieldsException
     * @throws UnknownCurrencyException
     */
    public function getLatest(string $conversionCurrency = CurrentCurrenciesEnum::USD): LatestCurrencyDto
    {
        if (!in_array($conversionCurrency, CurrentCurrenciesEnum::LIST, true)) {
            throw new UnknownCurrencyException();
        }

        $currentDate = new \DateTimeImmutable();
        $currentTimestamp = strtotime($currentDate->format('Y-m-d H:00:00'));
        $cacheKey = $this->cachePrefixApiService . '_' . $conversionCurrency . '_' . $currentTimestamp;
        $result = $this->cache->get($cacheKey);

        if (!$result) {
            $CurrentCurrenciesList = implode(',', CurrentCurrenciesEnum::LIST);

            $response = $this->httpClient->request('GET', 'latest.json', [
                'base_uri' => $this->urlApi,
                'query' => [
                    'app_id' => $this->appId,
                    'symbols' => $CurrentCurrenciesList,
                    // чтобы изменить валюту нужно иметь платный тариф
                    'base' => $conversionCurrency,
                    'prettyprint' => 'true',
                ]
            ]);

            $result = (string)$response->getBody();
            $result = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

            if (empty($result['timestamp']) || empty($result['base']) || empty($result['rates'])) {
                throw new MissingRequiredFieldsException();
            }

            $this->cache->set($cacheKey, $result, 3600);
        }

        /** MVP решение, по-хорошему тут нужно через DI опрокинуть свой какой-то datetimehelper и работать с ним */
        $dateConversion = new \DateTimeImmutable();
        $dateConversion->setTimestamp($result['timestamp']);

        $latestCurrencyDto = new LatestCurrencyDto();
        $latestCurrencyDto
            ->setCurrentCurrency($result['base'])
            ->setCurrentListConversion($result['rates'])
            ->setCurrentTime($dateConversion);

        return $latestCurrencyDto;
    }
}