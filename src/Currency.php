<?php 

namespace App;

class Currency{
    private $code;
    private $conversionRate;
    
    public function __construct(string $code, float $conversionRate)
    {
        $this->code = $code;
        $this->conversionRate = $conversionRate;
    }
    
    public function getCode(): string
    {
        return $this->code;
    }
    
    public function getConversionRate(): float
    {
        return $this->conversionRate;
    } 
}

?>

