<?php

namespace Commission\Calculator;

abstract class BaseCommissionCalculator implements CommissionStrategyCalculatorInterface
{
    public function calculate(float $amount, float $rate): float
    {
        return $this->getCoefficient() * $amount / $rate;
    }

    abstract protected function getCoefficient(): float;
}