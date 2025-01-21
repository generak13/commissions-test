<?php

namespace Commission\Entities;

class TransactionEntity {

    public readonly int $bin;
    public readonly float $amount;
    public readonly string $currency;

    public function __construct(array $data)
    {
      $this->bin = $data['bin'];
      $this->amount = $data['amount'];
      $this->currency = $data['currency'];
    }
}