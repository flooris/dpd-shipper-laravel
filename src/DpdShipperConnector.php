<?php

namespace Flooris\DpdShipper;

use Flooris\DpdShipper\Services\DpdLoginService;

class DpdShipperConnector
{
    public function __construct(
        private string $id,
        private string $password,
        private string $depotNumber,
        private string $baseUrl,
        private string $messageLanguage = 'en_US'
    )
    {

    }

    public function loginService(): DpdLoginService
    {
        return new DpdLoginService($this);
    }

    public function getSoapHeaderBody(): array
    {
        return [
            'delisId'         => $this->getId(),
            'password'        => $this->getPassword(),
            'messageLanguage' => $this->getMessageLanguage(),
        ];
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    private function getId(): string
    {
        return $this->id;
    }

    private function getPassword(): string
    {
        return $this->password;
    }

    private function getDepotNumber(): string
    {
        return $this->depotNumber;
    }

    private function getMessageLanguage(): string
    {
        return $this->messageLanguage;
    }
}
