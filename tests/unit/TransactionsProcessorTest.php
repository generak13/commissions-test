<?php

namespace Tests\Unit;

use Commission\Entities\TransactionEntity;
use Commission\Providers\BIN\BINEntity;
use Commission\TransactionsProcessor;
use PHPUnit\Framework\TestCase;

class TransactionsProcessorTest extends TestCase
{
    public function testEuTransaction()
    {
        $transaction = new TransactionEntity([
            'bin' => 45717360,
            'amount' => 100,
            'currency' => 'EUR',
        ]);
        $rate = 2;

        $processor = new TransactionsProcessor(
            $this->getTransactionsProviderMock([$transaction]),
            $this->getBINProviderMock($this->getEuBINEntity()),
            $this->getExchangeRatesProviderMock($rate),
            new \Commission\Calculator\CalculatorStrategyFactory(),
        );

        $commissions = $processor->run();

        $this->assertEquals(0.5, $commissions[0]);
    }

    public function testNonEuTransaction()
    {
        $transaction = new TransactionEntity([
            'bin' => 45717360,
            'amount' => 100,
            'currency' => 'EUR',
        ]);
        $rate = 2;

        $processor = new TransactionsProcessor(
            $this->getTransactionsProviderMock([$transaction]),
            $this->getBINProviderMock($this->getNonEuBINEntity()),
            $this->getExchangeRatesProviderMock($rate),
            new \Commission\Calculator\CalculatorStrategyFactory(),
        );

        $commissions = $processor->run();

        $this->assertEquals(1, $commissions[0]);
    }

    private function getTransactionsProviderMock(array $transactions)
    {
        return $this->createConfiguredMock(\Commission\Providers\TransactionsProviderInterface::class, [
            'run' => $transactions,
        ]);
    }

    private function getBINProviderMock(BINEntity $bin)
    {
        return $this->createConfiguredMock(\Commission\Providers\BIN\BINProviderInterface::class,[
            'run' => $bin,
        ]);
    }

    private function getExchangeRatesProviderMock(float $exchangeRate)
    {
        return $this->createConfiguredMock(\Commission\Providers\ExchangeRates\ExchangeRatesProvider::class, [
            'run' => $exchangeRate,
        ]);
    }

    private function getEuBINEntity(): BINEntity
    {
       return new BINEntity([
           'country' => [
               'alpha' => 'AT',
           ],
       ]);
    }

    private function getNonEuBINEntity(): BINEntity
    {
        return new BINEntity([
            'country' => [
                'alpha' => 'XYZ',
            ],
        ]);
    }
}