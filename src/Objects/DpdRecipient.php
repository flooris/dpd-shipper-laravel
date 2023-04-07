<?php

namespace Flooris\DpdShipper\Objects;

class DpdRecipient
{
    public function __construct(
        public readonly string $name1,
        public readonly string $street,
        public readonly string $houseNumber,
        public readonly string $countryIso,
        public readonly string $postalCode,
        public readonly string $city,
        public readonly string $email,
        public readonly string $type = 'P',
        public readonly string $name2 = '',
        public readonly string $street2 = '',
    )
    {
    }

    private const COUNTRIES_NON_EU = [
        'CH',
    ];

    public function isNonEuCountry(): bool
    {
        return in_array($this->countryIso, self::COUNTRIES_NON_EU, true);
    }
}
