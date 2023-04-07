<?php

namespace Flooris\DpdShipper\Objects;

use Illuminate\Support\Str;

class DpdRecipientOld
{
    private string $name1 = '';
    private string $name2 = '';
    private string $street = '';
    private string $street2 = '';
    private string $house_no = '';
    private string $country = '';
    private string $zip_code = '';
    private string $city = '';
    private string $type = '';
    private string $email = '';

    public const COUNTRIES_NON_EU = [
        'CH',
    ];

    /**
     * @return string
     */
    public function getName1(): string
    {
        return $this->name1;
    }

    /**
     * @param string $name1
     */
    public function setName1(string $name1): void
    {
        $this->name1 = Str::limit($name1, 32, '...');
    }

    /**
     * @return string
     */
    public function getName2(): string
    {
        return $this->name2;
    }

    /**
     * @param string $name2
     */
    public function setName2(string $name2): void
    {
        $this->name2 = Str::limit($name2, 32, '...');
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getStreet2(): string
    {
        return $this->street2;
    }

    public function setStreetAndHouseNoByAddress(string $address = ''): void
    {
        $regular_expression = "/^(\d*[\wäáàâåöóòôüúùûëéèêïíìîýÿÄÁÀÂÖÓÒÔÜÚÙÛËÉÈÊÏÍÌÎÝßñÑÇçšæÆ\d \'\/\\\\\-\.]+)[,\s]+(\d+)\s*([\wäáàâåöóòôüúùûëéèêïíìîýÿÄÁÀÂÖÓÒÔÜÚÙÛËÉÈÊÏÍÌÎÝßñÑÇçšæÆ\d\-\/]*)$/i";
        $split_matches = [];
        preg_match($regular_expression, $address, $split_matches);

        if (empty($split_matches)) {
            $this->setStreet($address);

            return;
        }

        $street = $split_matches[1];
        $house_no = $split_matches[2];
        $house_ext = $split_matches[3];

        $this->setStreet($street);
        $this->setHouseNo($house_no);
        $this->setStreet2($house_ext);
    }

    /**
     * @param string $street
     */
    public function setStreet($street): void
    {
        $this->street = Str::limit($street, 32, '...');
    }

    /**
     * @param string $street
     */
    public function setStreet2($street2): void
    {
        $this->street2 = Str::limit($street2, 32, '...');
    }

    /**
     * @return string
     */
    public function getHouseNo(): string
    {
        return $this->house_no;
    }

    public function setHouseNo(?string $house_no): void
    {
        if (! $house_no) {
            $this->house_no = '';

            return;
        }

        $this->house_no = Str::limit($house_no, 5, '...');
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     */
    public function setZipCode(string $zip_code): void
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = Str::limit($city, 32, '...');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function isNonEuCountry(): bool
    {
        $countryIso = $this->getCountry();

        return in_array($countryIso, self::COUNTRIES_NON_EU, true);
    }
}
