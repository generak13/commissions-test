<?php

namespace Commission\Calculator;

class EuroCommissionStrategyCalculator extends BaseCommissionCalculator
{
    protected function getCoefficient(): float
    {
        return 0.01;
    }
}