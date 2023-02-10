<?php

namespace App\Repositories\CurrencyRatesRepository;

class CurrencyRatesRepository
{
    public function getExchangeRates()
    {
        // Load the XML file
        $xml = simplexml_load_file('https://www.bank.lv/vk/ecb.xml');
        $rates = [];

        foreach ($xml->Currencies->Currency as $currency) {
            $id = (string) $currency->ID;
            $rate = (string) $currency->Rate;
            $rates[$id] = $rate;
        }

        $rates['EUR'] = "1";

        return $rates;
    }

    public function getRate(string $currency):float
    {
        $rates = $this->getExchangeRates();

        return $rates[$currency];
    }

    public function getAvailableCurrencies():array
    {
        $rates = $this->getExchangeRates();

        return array_keys($rates);
    }
}
