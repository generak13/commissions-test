<?php

namespace Commission\Providers;

use Commission\Entities\TransactionEntity;

class TransactionsProvider implements TransactionsProviderInterface
{
    public function __construct(private readonly string $content) {}

    public function run(): array
    {
        $lines = array_filter(explode(PHP_EOL, $this->content));

        return array_map(
            fn($line) => new TransactionEntity(json_decode($line, true)),
            $lines,
        );
    }
}
