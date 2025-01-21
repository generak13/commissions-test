<?php

namespace Commission\Calculator;

use Commission\Providers\BIN\BINEntity;

class CalculatorStrategyFactory
{
    public function getCalculatorStrategy(BINEntity $binEntity, float $rate): CommissionStrategyCalculatorInterface
    {
        return $binEntity->isEu() || $rate == 0 ?
            new EuroCommissionStrategyCalculator() :
            new NonEuroCommissionStrategyCalculator();
    }
}