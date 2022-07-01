<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrencyRatesService
{
    public static function getRates()
    {
        $base_currency = CurrencyConvertionService::getBaseCurrencyCode();
        $url = config('currency_rates.api_url') . $base_currency->code;

        $client = new Client();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() != 200)
            throw new \Exception('There is problem with currency rate');

        $rates = json_decode($response->getBody()->getContents(), true)['data'];

        foreach (CurrencyConvertionService::getCurrencies() as $currency)
        {
            if (! $currency->isMain())
            {
                if (! isset($rates[$currency->code]))
                    throw new \Exception('There is problem with currency rate');
                else
                    $currency->update(['rate' => $rates[$currency->code]]);
            }
        }
    }
}
