<?php 

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(
    name: 'app:calculate-profit',
    description: '',
    hidden: false,
)]
class CalculateTotalProfitCommand extends Command{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csvFilePath = dirname(__DIR__) . '/currency_conversion.csv';
        $totalProfit = 0;

        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $initialData = $data[0];
                $toData = $data[1];

                // splitting the amount and currency code
                list($initialAmount, $fromCurrencyCode) = explode(' ', $initialData);
                list($convertedAmount, $toCurrencyCode) = explode(' ', $toData);

                // Check if the initial or destination currency is AUD
                if ($toCurrencyCode === 'AUD') {
                    $profitInAUD = $convertedAmount * 0.15;
                    $totalProfit += $profitInAUD;
                }
                else if($fromCurrencyCode === 'AUD'){
                    $profitInAUD = $initialAmount * 0.15;
                    $totalProfit += $profitInAUD;
                }
            }
            fclose($handle);
        }

        $output->writeln("Total profit: {$totalProfit} AUD");

        return Command::SUCCESS;
    }
}  

?>