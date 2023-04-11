# DPD Shipper Laravel API

Laravel package for connecting to DPD Shipper API.

## Requirements

This package requires *Laravel 10.x* and *PHP 8.1* (or higher).

---

## Flooris

![Flooris visual](https://flooris.nl/img/containers/assets/header-image.webp/38313c04221b34c68cb027ed0d29a7ac.webp)
<!-- ![Some image](assets/flooris-visual.jpg) -->

We are a young and driven team of technicians with a mission. We ensure that our clients' online challenges are solved with manageable and sustainable tools. We connect existing and reliable solutions to each other. This allows us to create customized solutions, often in combination with professional (open-source) packages and APIs. We ensure that all online solutions always perform at the highest level. In addition, we provide professional support without hassle through our service portal.

---

## Install the package via composer

```bash
composer require flooris/dpd-shipper-laravel
```

## Publish the package config

```bash
php artisan vendor:publish --tag=dpd-shipper-config
nano config/dpd-shipper.php
```

---

## Usage example

```php
// Borsigstraße 20-22, 44145 Dortmund, Duitsland
// https://goo.gl/maps/FoKHQ4DwEEiY9ift5
$countryIso  = 'DE';
$postalCode  = '44145';
$parcelCount = 1;

$email       = 'test-dpd@flooris.nl';
$mobilePhone = '0612345678';

$shipmentProduct = new DpdShipmentProduct($countryIso, $postalCode);

$predict = $shipmentProduct->getPredict($countryIso, $email, $mobilePhone);

$parcels = new DpdParcels();
$parcels->setCustomerReferenceNumber1('TEST12345');
$parcels->setWeight(1);

$recipient = new DpdRecipient(
    name1: 'John Doe',
    street: 'Borsigstraße',
    houseNumber: '20-22',
    countryIso: 'DE',
    postalCode: $postalCode,
    city: 'Dortmund',
    email: $email
);

try {
    $shipmentLabel = $this->dpdShipperConnector->shipmentService()->createShipment(
        shipmentProduct: $shipmentProduct,
        parcelCount: $parcelCount,
        parcels: $parcels,
        sender: $this->dpdSender,
        recipient: $recipient,
        dpdPredict: $predict
    );
    
    $mpsId              = $shipmentLabel->mpsId;
    $barcodeCollection  = $shipmentLabel->getBarcodes();
    $pdfData            = $shipmentLabel->fileData;

} catch (DpdShipmentResponseException $e) {
} catch (\SoapFault $e) {
    throw $e;
}
```

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.


## Credits

- [Florian Kwakkenbos](https://github.com/fkwakkenbos)
- [All Contributors](../../contributors)
