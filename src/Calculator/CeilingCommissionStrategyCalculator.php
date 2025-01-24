<?php

namespace Commission\Calculator;

class CeilingCommissionStrategyCalculator implements CommissionStrategyCalculatorInterface
{
    private const PLACES = 2;

    public function __construct(private readonly CommissionStrategyCalculatorInterface $calculator) {}

    public function calculate(float $amount, float $rate): float
    {
        return $this->roundUp($this->calculator->calculate($amount, $rate), self::PLACES);
    }

    private function roundUp(float $value, int $places = 0): float
    {
        if ($places < 0) {
            $places = 0;
        }

        $multiplier = pow(10, $places);

        return ceil($value * $multiplier) / $multiplier;
    }
}