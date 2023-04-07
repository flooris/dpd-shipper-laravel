<?php

namespace Flooris\DpdShipper\Objects;

class DpdPredict
{
    public const PREDICT_CHANNEL_EMAIL = 1;
    public const PREDICT_CHANNEL_SMS = 3;
    public const PREDICT_DEFAULT_LANGUAGE = 'EN';

    /** @var int */
    private int $channel = self::PREDICT_CHANNEL_EMAIL;

    /** @var string */
    private string $value = '';

    /** @var string */
    private string $language = self::PREDICT_DEFAULT_LANGUAGE;

    /**
     * @return int
     */
    public function getChannel(): int
    {
        return $this->channel;
    }

    /**
     * @param int $channel
     */
    public function setChannel(int $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @param string $countryIsoCode2
     */
    public function setLanguageByCountryIsoCode2(string $countryIsoCode2): void
    {
        $language = match (strtoupper($countryIsoCode2)) {
            'BE' => 'NL',
            'DA' => 'EN',
            'AT' => 'DE',
            default => strtoupper($countryIsoCode2),
        };

        $this->setLanguage($language);
    }
}
