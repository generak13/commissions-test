<?php

namespace Commission\Providers\BIN;

interface BINProviderInterface
{
    public function run(int $bin): BINEntity;
}