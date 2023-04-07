<?php

namespace Flooris\DpdShipper\Objects;

class DpdSender
{
    public function __construct(
        public readonly string $name,
        public readonly string $street,
        public readonly string $houseNumber,
        public readonly string $countryIso,
        public readonly string $postalCode,
        public readonly string $city,
    )
    {

    }
}
