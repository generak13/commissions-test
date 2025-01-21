<?php

namespace Commission\Providers;

use Commission\Entities\TransactionEntity;

interface TransactionsProviderInterface
{
    public function run(): array;
}