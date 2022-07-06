<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrencyRatesService
{
    public function updateRates(): void
    {
        $url = $this->getUrl();

        $client = new Client();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() != 200)
            throw new \Exception('There is problem with currency rate');

        $rates = json_decode($response->getBody()->getContents(), true)['data'];

        $this->setRates($rates);
    }

    private function setRates($rates): void
    {
        foreach (CurrencyConvertionService::getCurrencies() as $currency)
        {
            if (! $currency->isMain())
            {
                if (isset($rates[$currency->code]))
                    $currency->update(['rate' => $rates[$currency->code]]);
                else
                    throw new \Exception('There is problem with currency rate');
            }
        }
    }

    private function getUrl(): string
    {
        $base_currency = CurrencyConvertionService::getBaseCurrencyCode();
        $url = config('currency_rates.api_url') . $base_currency->code;

        return $url;
    }
}
