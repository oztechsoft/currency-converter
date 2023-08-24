# Currency Conversion and Profit Calculation

This project provides a command-line tool for currency conversion and profit calculation based on predefined conversion rates and profit margins.

## Getting Started

### Prerequisites

- PHP (>= 8.1)
- Composer

### Installation

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/oztechsoft/currency-converter.git

2. Navigate to the project directory:

   ```bash
   cd currency-converter

3. Install the dependencies using Composer:

   ```bash
   composer install

### Usage

1. To perform currency conversion, use the following command:

   ```bash
   php bin/console app:currency-converter <amount> <fromCurrency> <toCurrency>

2. To calculate the total profit from currency conversions, use the following command:

   ```bash
   php bin/console app:calculate-profit

### Configuration
The project's conversion rates are defined in the CurrencyConverterCommand class in the src/Command/CurrencyConverterCommand.php file. You can modify these rates to suit your needs.



