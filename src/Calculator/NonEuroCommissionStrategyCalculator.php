<?php

namespace Commission\Calculator;

class NonEuroCommissionStrategyCalculator extends BaseCommissionCalculator
{
    protected function getCoefficient(): float
    {
        return 0.02;
    }
}