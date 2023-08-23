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
        $output->writeln('Hello World!');

        $amount = $input->getArgument('amount');
        $fromCurrencyCode = $input->getArgument('fromCurrency');
        $toCurrencyCode = $input->getArgument('toCurrency');

        $conversionRates = [
            new Currency('USD', 1.5),
            new Currency('NZD', 0.9),
            new Currency('GBP', 1.7),
            new Currency('EUR', 1.5),
            new Currency('AUD', 1.0)
        ];

        $fromCurrency = null;
        $toCurrency = null;

        foreach ($conversionRates as $currency) {
            if ($currency->getCode() === $fromCurrencyCode) {
                $fromCurrency = $currency;
            }
            if ($currency->getCode() === $toCurrencyCode) {
                $toCurrency = $currency;
            }
        }

        if (!$fromCurrency || !$toCurrency) {
            $output->writeln('Invalid currency code.');
            return Command::FAILURE;
        }

        $converter = new CurrencyConverter($amount, $fromCurrency, $toCurrency);
        $convertedAmount = $converter->convert();

        $output->writeln("Converted amount: $convertedAmount {$toCurrency->getCode()}");
        $converter->convertToCSV();
        $output->writeln("Data sent to CSV");

        return Command::SUCCESS;
    }
}

?>