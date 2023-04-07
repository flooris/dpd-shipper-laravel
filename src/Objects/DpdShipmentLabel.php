<?php

namespace Flooris\DpdShipper\Objects;

use Illuminate\Support\Collection;

class DpdShipmentLabel
{
    public function __construct(
        public string $mpsId,
        public array $barcodes,
        public string $fileData,
        public string $fileType
    )
    {
    }

    public function getBarcodes(): Collection
    {
        return collect($this->barcodes);
    }
}
