<?php

namespace App\Services;

use App\Repositories\CurrencyRatesRepository\CurrencyRatesRepository;

class CurrencyConversionService
{
    private CurrencyRatesRepository $currencyRatesRepository;

    public function __construct(CurrencyRatesRepository $currencyRatesRepository)
    {
        $this->currencyRatesRepository = $currencyRatesRepository;
    }

    public function convert(string $currencyFrom, string $currencyTo, int $amount): float
    {
        if (!($currencyFrom === "EUR")) {
            $amount = $this->deconvert($amount, $currencyFrom);
        }

        $currencyRate = $this->currencyRatesRepository->getRate($currencyTo);

        return round(($currencyRate * $amount), 2);
    }

    private function deconvert(int $amount, string $currencyFrom): float
    {
        $currencyRate = $this->currencyRatesRepository->getRate($currencyFrom);

        return round(($amount / $currencyRate), 2);
    }

    public function getAvailableCurrencies(): array
    {
        $currencies = $this->currencyRatesRepository->getAvailableCurrencies();

        return $currencies;
    }
}
