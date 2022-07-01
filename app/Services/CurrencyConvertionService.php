<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Currency;

class CurrencyConvertionService
{
    private static $container;

    public static function loadContainer(): void
    {
        if (is_null(self::$container))
        {
            $currencies = Currency::get();

            foreach ($currencies as $currency)
            {
                self::$container[$currency->code] = $currency;
            }
        }
    }

    public static function convert(float $sum, string $originCurrencyCode = 'RUB', ?string $targetCurrencyCode = null): float
    {
        self::loadContainer();

        $originCurrency = self::$container[$originCurrencyCode];

        if (is_null($targetCurrencyCode))
        {
            $targetCurrencyCode = session('currency', 'RUB');
        }

        $targetCurrency = self::$container[$targetCurrencyCode];

        return round($sum / $originCurrency->rate * $targetCurrency->rate, 2);
    }

    public static function getCurrencySymbol(): string
    {
        self::loadContainer();

        $currency = self::$container[session('currency', 'RUB')];

        return $currency->symbol;
    }

    public static function getCurrencies(): array
    {
        self::loadContainer();

        return self::$container;
    }

    public static function getBaseCurrencyCode()
    {
        self::loadContainer();

        foreach (self::$container as $code => $currency)
        {
            if ($currency->is_main)
            {
                return $currency;
            }
        }
    }
}
