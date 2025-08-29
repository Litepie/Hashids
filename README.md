# Litepie Hashids

[![Latest Version on Packagist](https://img.shields.io/packagist/v/litepie/hashids.svg?style=flat-square)](https://packagist.org/packages/litepie/hashids)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/litepie/hashids/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/litepie/hashids/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/litepie/hashids/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/litepie/hashids/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/litepie/hashids.svg?style=flat-square)](https://packagist.org/packages/litepie/hashids)

A Laravel package for encoding and decoding database IDs using [Sqids](https://sqids.org/) (next-generation Hashids). This package provides a clean way to obfuscate your database IDs in URLs and API responses while maintaining Laravel conventions.

## Features

- 🔢 Encode/decode database IDs using Sqids (next-gen Hashids)
- 🛡️ Built-in profanity filter with customizable blocklist
- 🎭 Eloquent model trait for automatic ID handling
- 🛣️ Route model binding support with encoded IDs
- ✍️ Signed IDs with expiration support
- 🔧 Helper functions for easy usage
- ⚙️ Configurable alphabet, length, and blocklist
- 🚀 Laravel 10, 11, and 12 support
- 🧪 Comprehensive test suite with Pest
- 📝 Full static analysis with PHPStan
- ⚡ Better performance than traditional Hashids

## Requirements

- PHP 8.2+
- Laravel 10.x, 11.x, or 12.x
- BCMath or GMP extension (automatically handled by Sqids)

## Installation

Install the package via Composer:

```bash
composer require litepie/hashids
```

The service provider will be automatically registered. To publish the config file:

```bash
php artisan vendor:publish --provider="Litepie\Hashids\HashidsServiceProvider" --tag="hashids-config"
```

## Configuration

The configuration file `config/hashids.php` allows you to customize:

```php
return [
    'alphabet' => env('HASHIDS_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),
    'length' => env('HASHIDS_LENGTH', 0),
    'blocklist' => env('HASHIDS_BLOCKLIST') ? explode(',', env('HASHIDS_BLOCKLIST')) : null,
];
```

You can also set these values in your `.env` file:

```env
HASHIDS_ALPHABET=abcdefghijklmnopqrstuvwxyz1234567890
HASHIDS_LENGTH=10
HASHIDS_BLOCKLIST=word1,word2,word3
```

## Usage

### Helper Functions

```php
// Encode an ID
$hash = hashids_encode(123); // returns something like "bM"

// Decode a hash
$id = hashids_decode('bM'); // returns 123

// Encode multiple values
$hash = hashids_encode([123, 456]); // encode multiple values

// Decode to array
$ids = hashids_decode('86Rf07'); // returns [123, 456]

// Using new Sqids functions (aliases)
$hash = sqids_encode(123); // same as hashids_encode
$id = sqids_decode('bM'); // same as hashids_decode
```

### Facade

```php
use Litepie\Hashids\Facades\Hashids;

$hash = Hashids::encode([123]);
$id = Hashids::decode('bM');
```

### Eloquent Model Trait

Add the trait to your Eloquent models:

```php
use Litepie\Hashids\Traits\Hashids;

class User extends Model
{
    use Hashids;
    
    // Your model code...
}
```

#### Available Methods

```php
// Get encoded ID
$user = User::find(1);
echo $user->eid; // encoded ID attribute
echo $user->getRouteKey(); // for route model binding

// Find by encoded ID
$user = User::findOrFail('bM');
$user = User::findOrNew('bM');

// Signed IDs (with expiration)
$signedId = $user->getSignedId('+1 hour'); // expires in 1 hour
$signedId = $user->getSignedId(1234567890); // expires at timestamp
$signedId = $user->getSignedId(); // never expires

// Find by signed ID
$user = User::findBySignedId($signedId);
```

#### Route Model Binding

The trait automatically supports Laravel's route model binding:

```php
// routes/web.php
Route::get('/users/{user}', function (User $user) {
    return $user;
});
```

Now you can use encoded IDs in your URLs:
```
/users/bM instead of /users/1
```

## Security

- The alphabet is automatically shuffled for uniqueness
- Built-in profanity filter prevents offensive words in IDs  
- Signed IDs include salt verification and optional expiration
- IDs are obfuscated but not encrypted (don't rely on them for security)
- Customizable blocklist for additional word filtering

## Why Sqids over Hashids?

This package uses [Sqids](https://sqids.org/) instead of traditional Hashids, providing:

- ⚡ **Better Performance** - More efficient algorithm
- 🛡️ **Built-in Profanity Filter** - Automatic offensive word prevention
- 🎛️ **Custom Blocklist** - Block specific words from appearing in IDs
- 🔧 **Modern PHP** - Optimized for PHP 8.2+
- 📈 **Active Development** - Regular updates and improvements

## Testing

```bash
composer test
```

### Running Static Analysis

```bash
composer analyse
```

### Code Style Fixing

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lavalite Team](https://github.com/litepie)
- [All Contributors](../../contributors)

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

- **Issues**: [GitHub Issues](https://github.com/litepie/hashids/issues)
- **Documentation**: [README](https://github.com/litepie/hashids#readme)
- **Source**: [GitHub Repository](https://github.com/litepie/hashids)

---

## 🏢 About

This package is part of the **Litepie** ecosystem, developed by **Renfos Technologies**. 

### Organization Structure
- **Vendor:** Litepie
- **Framework:** Lavalite
- **Company:** Renfos Technologies

### Links & Resources
- 🌐 **Website:** [https://lavalite.org](https://lavalite.org)
- 📚 **Documentation:** [https://docs.lavalite.org](https://docs.lavalite.org)
- 💼 **Company:** [https://renfos.com](https://renfos.com)
- 📧 **Support:** [support@lavalite.org](mailto:support@lavalite.org)

---

<div align="center">
  <p><strong>Built with ❤️ by Renfos Technologies</strong></p>
  <p><em>Empowering developers with robust Laravel solutions</em></p>
</div>
