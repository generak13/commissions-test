<?php

namespace Commission;

use Commission\Calculator\CalculatorStrategyFactory;
use Commission\Entities\TransactionEntity;
use Commission\Providers\BIN\BINProviderInterface;
use Commission\Providers\ExchangeRates\ExchangeRatesProviderInterface;
use Commission\Providers\TransactionsProviderInterface;

class TransactionsProcessor
{
    public function __construct(
        private readonly TransactionsProviderInterface  $transactionsProvider,
        private readonly BINProviderInterface           $binProvider,
        private readonly ExchangeRatesProviderInterface $exchangeRatesProvider,
        private readonly CalculatorStrategyFactory      $calculatorStrategyFactory,
    ) {}

    public function run(): array
    {
        $result = [];

        foreach ($this->transactionsProvider->run() as $transaction) {
            /** @var TransactionEntity $transaction */
            $binEntity = $this->binProvider->run($transaction->bin);
            $rate = $this->exchangeRatesProvider->run($transaction->currency);

            $calculator = $this->calculatorStrategyFactory->getCalculatorStrategy($binEntity, $rate);

            $result[] = $calculator->calculate($transaction->amount, $rate);
        }

        return $result;
    }
}