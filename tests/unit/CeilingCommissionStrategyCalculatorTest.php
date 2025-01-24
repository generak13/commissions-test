<?php

namespace Tests\Unit;

use Commission\Calculator\EuroCommissionStrategyCalculator;
use Commission\Calculator\NonEuroCommissionStrategyCalculator;
use Commission\Calculator\CeilingCommissionStrategyCalculator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CeilingCommissionStrategyCalculatorTest extends TestCase
{
    #[DataProvider('euDataProvider')]
    public function testEu(int $amount, int $rate, float $expected)
    {
        $strategy = new CeilingCommissionStrategyCalculator(
            new EuroCommissionStrategyCalculator(),
        );

        $this->assertEquals(
            $expected,
            $strategy->calculate($amount, $rate)
        );
    }

    public static function euDataProvider(): array
    {
        return [
            [100, 3, 0.34],
            [110, 3, 0.37],
        ];
    }

    #[DataProvider('nonEuDataProvider')]
    public function testNonEu(int $amount, int $rate, float $expected)
    {
        $strategy = new CeilingCommissionStrategyCalculator(
            new NonEuroCommissionStrategyCalculator(),
        );

        $this->assertEquals(
            $expected,
            $strategy->calculate($amount, $rate)
        );
    }

    public static function nonEuDataProvider(): array
    {
        return [
            [100, 3, 0.67],
            [110, 3, 0.74],
        ];
    }
}