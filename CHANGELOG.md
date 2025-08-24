# Changelog

All notable changes to `litepie/hashids` will be documented in this file.

## [Unreleased]

### Added
- Initial package implementation
- Service provider for Laravel integration
- Configuration file with salt, length, and alphabet options
- Helper functions: `hashids_encode()`, `hashids_decode()`, `hashids_encode_hex()`, `hashids_decode_hex()`
- Eloquent model trait with hashid support
- Route model binding support
- Signed IDs with expiration support
- Facade for convenient access
- Comprehensive test suite
- Documentation and examples

### Features
- Encode/decode database IDs using Hashids library
- Automatic route model binding with encoded IDs
- Signed IDs with timestamp validation
- Configurable via environment variables
- PSR-4 autoloading
- Laravel package auto-discovery

### Dependencies
- PHP ^8.1
- Laravel ^10.0|^11.0
- hashids/hashids ^5.0

## [1.0.0] - 2025-08-24

### Added
- Initial release
