<?php

namespace Flooris\DpdShipper\Objects;

class DpdShipmentProduct
{
    private const REGEX_MOBILE_PHONE_COUNTRIES = [
        'FR' => [
            '/([0]|[3]{2})([6-7][0-9]{8}$)/i', // https://en.wikipedia.org/wiki/Telephone_numbers_in_France
        ],
    ];

    /**
     * Countries that won't receive DPD pro-active predict notices.
     *
     * @var array $excluded_predict_countries
     */
    const EXCLUDED_PREDICT_COUNTRY_ISOS = [
        'IT',
    ];

    const DPD_PRODUCT_CLASSIC = 'CL';
    const DPD_PRODUCT_B2B = 'B2B';

    public function __construct(
        private readonly string $countryIso,
        private ?string         $postalCode
    )
    {
        if ($this->postalCode) {
            $this->postalCode = strtoupper(preg_replace('/\s+/', '', $this->postalCode));
        }
    }

    /**
     * Get DPD Service Product Code.
     *
     * @return string
     */
    public function getServiceProductCode(): string
    {
        if ($this->countryIso === "FR") {
            return self::DPD_PRODUCT_B2B;
        }

        return self::DPD_PRODUCT_CLASSIC;
    }

    public function getPredict(string $countryIso, ?string $email, ?string $mobilePhone): ?DpdPredict
    {
        if (! $this->hasProactiveMessage()) {
            return null;
        }

        if ($this->isValidMobilePhone($countryIso, $mobilePhone)) {
            $predict = new DpdPredict();
            $predict->setChannel(DpdPredict::PREDICT_CHANNEL_SMS);
            $predict->setValue($mobilePhone);
            $predict->setLanguageByCountryIsoCode2($countryIso);

            return $predict;
        }

        $predict = new DpdPredict();
        $predict->setChannel(DpdPredict::PREDICT_CHANNEL_EMAIL);
        $predict->setValue($email);
        $predict->setLanguageByCountryIsoCode2($countryIso);

        return $predict;
    }

    /**
     * Whether the DPD Shipment has a Proactive message (DPD predict) yes/no.
     *
     * @return bool
     */
    public function hasProactiveMessage(): bool
    {
        if (in_array($this->countryIso, self::EXCLUDED_PREDICT_COUNTRY_ISOS)) {
            return false;
        }

        return true;
    }

    /**
     * Whether the DPD Shipment can use Saturday Shipping yes/no.
     *
     * @return bool
     */
    public function useSaturdayShipping(): bool
    {
        return false;
    }

    /**
     * Get DPD depot code (number).
     *
     * @return string
     */
    public function getRegionAccount(): string
    {
        return 'default';
    }

    private function isValidMobilePhone(string $countryIso, ?string $mobilePhone): bool
    {
        if (! isset(self::REGEX_MOBILE_PHONE_COUNTRIES[$countryIso])) {
            return false;
        }

        foreach (self::REGEX_MOBILE_PHONE_COUNTRIES[$countryIso] as $regPattern) {
            if (preg_match($regPattern, $mobilePhone) === 1) {
                return true;
            }
        }

        return false;
    }
}
