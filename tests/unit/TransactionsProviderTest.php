<?php

namespace Tests\Unit;

use Commission\Providers\TransactionsProvider;
use PHPUnit\Framework\TestCase;

class TransactionsProviderTest extends TestCase
{
    public function testParseJson()
    {
        $content = '{"bin":"45717360","amount":"100.00","currency":"EUR"}';

        $actual = (new TransactionsProvider($content))->run();

        $this->assertEquals(new \Commission\Entities\TransactionEntity([
            'bin' => '45717360',
            'amount' => '100.00',
            'currency' => 'EUR',
        ]), $actual[0]);
    }

    public function testJsonWithMoreContent()
    {
        $content = '{"bin":"45717360","amount":"100.00","currency":"EUR", "zxc": 33}';

        $actual = (new TransactionsProvider($content))->run();

        $this->assertEquals(new \Commission\Entities\TransactionEntity([
            'bin' => '45717360',
            'amount' => '100.00',
            'currency' => 'EUR',
        ]), $actual[0]);
    }

    public function testParseFewJsons()
    {
        $content = '{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}';

        $actual = (new TransactionsProvider($content))->run();

        $this->assertCount(5, $actual);
    }

    public function testSkipEmptyLines()
    {
        $content = <<<AAA

{"bin":"45717360","amount":"100.00","currency":"EUR"}

{"bin":"45717360","amount":"100.00","currency":"EUR"}

AAA;

        $actual = (new TransactionsProvider($content))->run();

        $this->assertCount(2, $actual);
    }
}