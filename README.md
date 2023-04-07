# DPD Shipper Laravel PHP API

Laravel package for connecting to DPD Shipper API.


## Requirements
---

This package requires *Laravel 10.x* and *PHP 8.1* (or higher).


## Install the package via composer
---

```bash
composer require flooris/dpd-shipper-laravel
```


## Publish the package config
---

```bash
php artisan vendor:publish --tag=dpd-shipper-config
nano config/dpd-shipper.php
```

## Usage example
---

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


## Changelog
---

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
