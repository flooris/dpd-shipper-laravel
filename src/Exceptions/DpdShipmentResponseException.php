<?php

namespace Flooris\DpdShipper\Exceptions;

use Throwable;

class DpdShipmentResponseException extends \Exception
{
    public function __construct(
        string $message,
        public ?array $shipmentData,
        public ?\StdClass $orderResult,
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
