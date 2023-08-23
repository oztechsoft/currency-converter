<?php 

namespace App;

class CurrencyConverter
{
    private $amount;
    private $fromCurrency;
    private $convertedAmount;
    private $toCurrency;
    
    public function __construct(float $amount, Currency $fromCurrency, Currency $toCurrency)
    {
        $this->amount = $amount;
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
    }

    public function convert(): float
    {
        $this->convertedAmount = $this->amount * ($this->toCurrency->getConversionRate() / $this->fromCurrency->getConversionRate());
        return $this->convertedAmount;
    }

    public function convertToCSV(){
        $fromCurrencyCode = $this->fromCurrency->getCode();
        $toCurrencyCode = $this->toCurrency->getCode();
    
        $csvData = "{$this->amount} {$fromCurrencyCode}, {$this->convertedAmount} {$toCurrencyCode}\n";
        file_put_contents('currency_conversion.csv', $csvData, FILE_APPEND);
    }
}

?>