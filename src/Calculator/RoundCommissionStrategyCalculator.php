<?php

namespace Commission\Calculator;

class RoundCommissionStrategyCalculator implements CommissionStrategyCalculatorInterface
{
    public function __construct(private readonly CommissionStrategyCalculatorInterface $calculator) {}

    public function calculate(float $amount, float $rate): float
    {
        return round($this->calculator->calculate($amount, $rate), 2);
    }
}