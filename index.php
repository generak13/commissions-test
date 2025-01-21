<?php

require 'vendor/autoload.php';

use Commission\Providers\TransactionsProvider;
use Commission\TransactionsProcessor;
use Dotenv\Dotenv;

define('BASE_PATH', __DIR__);

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($argc < 2) {
    die('Filename is not specified');
}

$filename = $argv[1];

if (!file_exists(storage_path($filename))) {
    die('File not found');
}

$processor = new TransactionsProcessor(
    new TransactionsProvider(file_get_contents(storage_path($filename))),
    new \Commission\Providers\BIN\BINProvider(),
    new \Commission\Providers\ExchangeRates\ExchangeRatesProvider(),
    new \Commission\Calculator\CalculatorStrategyFactory(),
);

$transactionsCommissions = $processor->run();

$outputFilename = pathinfo($filename, PATHINFO_FILENAME) . '_out';
file_put_contents(storage_path($outputFilename), implode(PHP_EOL, $transactionsCommissions));