<?php

namespace Commission\Providers\BIN;


use Commission\Providers\BIN\Exceptions\BadConnectionException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BINProvider implements BINProviderInterface
{
    private const host = 'https://lookup.binlist.net';

    private array $cache = [];

    /**
     * @throws BadConnectionException
     */
    public function run(int $bin): BINEntity
    {
        if (!isset($this->cache[$bin])) {
            $this->fetchBINInfo($bin);
        }

        return $this->cache[$bin];
    }

    private function fetchBINInfo(int $bin): void
    {
        $client = new Client();
        $response = $client->get(self::host . '/' . $bin);

        if ($response->getStatusCode() !== 200) {
            throw new BadConnectionException('BIN Server response code is  ' . $response->getStatusCode());
        }

        $this->cache[$bin] = new BINEntity(json_decode($response->getBody(), true));
    }
}