<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\Currency;
use App\CurrencyConverter;

#[AsCommand(
    name: 'app:convert-currency',
    description: 'convert currency ammount to another currency specified',
    hidden: false,
)]
class CurrencyConvertCommand extends Command
{
    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to convert your currency amount into another currency...')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount to convert')
            ->addArgument('fromCurrency', InputArgument::REQUIRED, 'From currency code')
            ->addArgument('toCurrency', InputArgument::REQUIRED, 'To currency code');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // user input should include amount, fromCurrency and toCurrency
        $amount = $input->getArgument('amount');
        $fromCurrencyCode = $input->getArgument('fromCurrency');
        $toCurrencyCode = $input->getArgument('toCurrency');

        // conversion rates. New rates can be added.
        $conversionRates = [
            new Currency('USD', 1.5),
            new Currency('NZD', 0.9),
            new Currency('GBP', 1.7),
            new Currency('EUR', 1.5),
            new Currency('AUD', 1.0)
        ];

        $fromCurrency = null;
        $toCurrency = null;

        // Get the fromCurrency and toCurrency values
        foreach ($conversionRates as $currency) {
            if ($currency->getCode() === $fromCurrencyCode) {
                $fromCurrency = $currency;
            }
            if ($currency->getCode() === $toCurrencyCode) {
                $toCurrency = $currency;
            }
        }

        // return error if currency does not match the conversion rates
        if (!$fromCurrency || !$toCurrency) {
            $output->writeln('Invalid currency code.');
            return Command::FAILURE;
        }

        // convert the amount and display convertd amount
        $converter = new CurrencyConverter($amount, $fromCurrency, $toCurrency);
        $convertedAmount = $converter->convert();
        $output->writeln("Converted amount: $convertedAmount {$toCurrency->getCode()}");

        // Add data to csv file
        $converter->convertToCSV();

        return Command::SUCCESS;
    }
}

?>