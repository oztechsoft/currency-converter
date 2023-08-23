<?php 

namespace App;

class CurrencyConverter
{
    public function convert(float $amount, Currency $fromCurrency, Currency $toCurrency): float
    {
        return $amount * ($toCurrency->getConversionRate() / $fromCurrency->getConversionRate());
    }
}

?>