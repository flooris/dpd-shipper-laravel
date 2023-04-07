<?php

namespace Flooris\DpdShipper\Services;

use Flooris\DpdShipper\Exceptions\DpdAuthenticationException;
use SoapFault;

class DpdLoginService extends AbstractDpdService
{
    const SERVICE_NAME = 'LoginService';
    const SERVICE_VERSION = 'V20';
    const SERVICE_LOGIN_METHOD_NAME = 'getAuth';

    /**
     * @throws DpdAuthenticationException
     */
    public function getApiToken(): string
    {
        if ($token = $this->connector->getApiTokenFromCache()) {
            return $token;
        }

        try {

            $result = $this->doSoapRequest(
                serviceName: self::SERVICE_NAME,
                serviceVersion: self::SERVICE_VERSION,
                soapMethod: self::SERVICE_LOGIN_METHOD_NAME,
                soapHeader: null,
                data: [
                    'delisId'         => $this->connector->id,
                    'password'        => $this->connector->password,
                    'messageLanguage' => $this->connector->messageLanguage,
                ]
            );

        } catch (SoapFault $e) {
            throw new DpdAuthenticationException('DPD authentication error', 0, $e);
        }

        $token = $result?->return?->authToken;
        if (! $token) {
            throw new DpdAuthenticationException('DPD authentication error - API token is invalid!');
        }

        $this->connector->storeApiTokenInCache($token);

        return $token;
    }
}
