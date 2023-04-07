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
        //        $token_cache_key = $this->getApiTokenCacheKey();
        //
        //        if (Cache::has($token_cache_key)) {
        //            return Cache::get($token_cache_key);
        //        }

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

        $api_token  = $result->return->authToken;
        $expires_at = Carbon::now()->addMinutes(120);

        //        Cache::put($token_cache_key, $api_token, $expires_at);

        return $api_token;
    }
}
