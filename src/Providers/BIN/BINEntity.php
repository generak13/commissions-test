<?php

namespace Commission\Providers\BIN;

class BINEntity
{
    private const EuCodesList = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function __construct(private array $data) {}

    private function getCountryAlphaCode(): ?string
    {
        return $this->data['country']['alpha'] ?? null;
    }

    public function isEu(): bool
    {
        $alphaCode = $this->getCountryAlphaCode();

        if (!$alphaCode) {
            return false;
        }

        return in_array($alphaCode, self::EuCodesList);
    }
}