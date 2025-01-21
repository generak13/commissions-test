<?php

namespace Commission\Calculator;

interface CommissionStrategyCalculatorInterface
{
    public function calculate(float $amount, float $rate): float;
}