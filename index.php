<?php

require 'vendor/autoload.php';

use Commission\Providers\TransactionsProvider;
use Commission\TransactionsProcessor;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($argc < 2) {
    die('Filename is not specified');
}

$filename = $argv[1];
$fileSystemHelper = new \Commission\Helpers\FileSystem(__DIR__);

if (!file_exists($fileSystemHelper->getStoragePath($filename))) {
    die('File not found');
}

$processor = new TransactionsProcessor(
    new TransactionsProvider(file_get_contents($fileSystemHelper->getStoragePath($filename))),
    new \Commission\Providers\BIN\BINProvider(),
    new \Commission\Providers\ExchangeRates\ExchangeRatesProvider(),
    new \Commission\Calculator\CalculatorStrategyFactory(),
);

$transactionsCommissions = $processor->run();

$outputFilename = pathinfo($filename, PATHINFO_FILENAME) . '_out';
file_put_contents($fileSystemHelper->getStoragePath($outputFilename), implode(PHP_EOL, $transactionsCommissions));