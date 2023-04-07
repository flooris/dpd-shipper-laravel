# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.0.1] - 2023-04-07

We're super excited to announce `WIP` 0.0.1!

This initial concept release is fully focuses on getting started
and get things up and running.

### Major changes

- Initial setup
- Added Laravel packages (dependencies) for using Cache, Collection and Config
- Added DpdShipmentResponseException
- Added DpdShipmentService
- Refactored code to the AbstractDpdService for SOAP logic, which also refactored the DpdLoginService
- Refactored DpdShipperConnector for managing the DPD Shipper API token
- Added the default DpdSender to the Service Provider which gets the address information from the config/dpd-shipper.php
- Added all Object Classes
- Added the changelog
- Added the MIT license description
- Added the DPD authentication URL to the config/dpd-shipper.php
- Updated the README.md

### Changed features

- Added DPD Shipper Login service
- Added DPD create shipment service
