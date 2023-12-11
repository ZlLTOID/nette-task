<?php

namespace App\Cron;

use App;
use App\Repository\ContractRepository;
use App\Service\ExchangeRatesProvider;
use Throwable;

require __DIR__ . '/../vendor/autoload.php';

$container = App\Bootstrap::boot()->createContainer();

$exchangeRateProvider = $container->getByType(ExchangeRatesProvider::class);
$contractRepository = $container->getByType(ContractRepository::class);

try {
    $contracts = $contractRepository->findAllForCommand();
    foreach ($contracts as $contract) {
        $contract->update([
            ContractRepository::PRICE_EUR => $exchangeRateProvider->getEURPrice($contract->priceCZK),
            ContractRepository::PRICE_USD => $exchangeRateProvider->getUSDPrice($contract->priceCZK),
        ]);
    }

    exit(0);
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}