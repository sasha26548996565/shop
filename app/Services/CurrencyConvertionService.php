<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use App\Models\Currency;
use App\Services\CurrencyRatesService;
use GuzzleHttp\Client;

class CurrencyConvertionService
{
    // private const DEFAULT_CURRENCY_CODE = 'RUB';

    // private static CurrencyRatesService $currencyRates;
    // private static $container;

    // public static function loadContainer(): void
    // {
    //     if (is_null(self::$container))
    //     {
    //         $currencies = Currency::get();

    //         foreach ($currencies as $currency)
    //         {
    //             self::$container[$currency->code] = $currency;
    //         }
    //     }

    //     $client = new Client();
    //     self::$currencyRates = new CurrencyRatesService(new Client());
    // }

    // public static function convert(float $sum = 100, string $originCurrencyCode = self::DEFAULT_CURRENCY_CODE, ?string $targetCurrencyCode = null): float
    // {
    //     self::loadContainer();

    //     $originCurrency = self::$container[$originCurrencyCode];

    //     if (is_null($targetCurrencyCode))
    //     {
    //         $targetCurrencyCode = self::getCurrencyFromSession();
    //     }

    //     $targetCurrency = self::$container[$targetCurrencyCode];

    //     return round($sum / $originCurrency->rate * $targetCurrency->rate, 2);
    // }

    // public static function getCurrencySymbol(): string
    // {
    //     self::loadContainer();

    //     $currency = self::$container[self::getCurrencyFromSession()];

    //     return $currency->symbol;
    // }

    // public static function getCurrencies(): array
    // {
    //     self::loadContainer();

    //     return self::$container;
    // }

    // public static function getBaseCurrencyCode()
    // {
    //     self::loadContainer();

    //     foreach (self::$container as $code => $currency)
    //     {
    //         if ($currency->is_main)
    //         {
    //             return $currency;
    //         }
    //     }
    // }

    // public static function getCurrencyFromSession()
    // {
    //     return session('currency', self::DEFAULT_CURRENCY_CODE);
    // }

    // public static function getCurrentCurrencyFromSession()
    // {
    //     self::loadContainer();

    //     foreach (self::$container as $currency)
    //     {
    //         if ($currency->code == self::getCurrencyFromSession());
    //         {
    //             return $currency;
    //         }
    //     }
    // }
}
