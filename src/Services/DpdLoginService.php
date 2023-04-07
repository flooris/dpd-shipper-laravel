<?php

namespace Flooris\DpdShipper\Services;

use Illuminate\Support\Facades\Cache;
use Flooris\DpdShipper\DpdShipperConnector;
use Flooris\DpdShipper\Exceptions\DpdAuthenticationException;
use Carbon\Carbon;
use SoapClient;
use SoapFault;
use SoapHeader;

class DpdLoginService
{
    const CACHE_KEY_API_TOKEN = 'FLOORIS_DPD_API_TOKEN';
    const SERVICE_NAME = 'LoginService';
    const SERVICE_VERSION = 'V20';

    public function __construct(
        private DpdShipperConnector $connector
    )
    {

    }

    /**
     * Get DIS Auth Token.
     *
     * @return string DPD DIS Api Token
     * @throws DpdAuthenticationException
     * @throws SoapFault
     */
    public function getApiToken(): string
    {
        if (Cache::has(self::CACHE_KEY_API_TOKEN)) {
            return Cache::get(self::CACHE_KEY_API_TOKEN);
        }

        $serviceBaseUrl = $this->connector->getBaseUrl();
        $serviceName    = self::SERVICE_NAME;
        $serviceVersion = self::SERVICE_VERSION;
        $serviceUrl     = "{$serviceBaseUrl}{$serviceName}{$serviceVersion}.wsdl";
        $clientOptions  = ['trace' => true, 'exceptions' => true];

        try {
            $client = new SoapClient($serviceUrl, $clientOptions);
            $result = $client->getAuth($this->connector->getSoapHeaderBody());

        } catch (SoapFault $e) {
            throw new DpdAuthenticationException('DPD authentication error', 0, $e);
        }

        $token = $result?->return?->authToken;
        if (! $token) {
            throw new DpdAuthenticationException('DPD authentication error - API token is invalid!');
        }

        $expiresAt = Carbon::now()->addMinutes(120);

        Cache::put(self::CACHE_KEY_API_TOKEN, $token, $expiresAt);

        return $token;
    }
}
