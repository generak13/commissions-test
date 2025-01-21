<?php

namespace Commission\Providers\ExchangeRates;

interface ExchangeRatesProviderInterface
{
    public function run(string $currency): float;
}