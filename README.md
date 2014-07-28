# Php54to55

This is a collection of sniffs for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
to test PHP 5.4 applications for compatibility with PHP 5.5.

**This project is currently under development**

[![Build Status](https://secure.travis-ci.org/foobugs-standards/Php54to55.png?branch=master)](https://travis-ci.org/foobugs-standards/Php54to55)

# Requirements

- PHP >= 5.5.0

(Requires at least PHP 5.3.2 but will not properly test `trait` names until PHP 5.4.0 or later.)

(It is suggested that you test compatibility with PHP 5.5 or newer in order to use the most up-to-date PHP parser/ tokenizer.)

# Features

* Check for deprecated & removed functions (`MySQL`, `mycrypt_*`)
* Check for `/e` modifier in regular expressions
* Check for removed Constants (`MySQL`)
* Check for `setTimeZoneID` or `datefmt_set_timezone_id` usage
* Check for definitions of global functions which are [new in PHP 5.5](http://www.php.net/manual/en/migration55.new-functions.php)
* Check for definitions of classes that have been added in PHP 5.5
* Check for definitions of constants that have been added in PHP 5.5

[Detailed feature list](FEATURES.md).

# Usage

Add `"foobugs-standards/php54to55": "~2"` to your `composer.json`:

```json
{
  "require": {
    "foobugs-standards/php54to55": "~2"
  }
}
```

Run the following commands:

```bash
composer install

# test full standard
vendor/bin/snout --standard=Php54to55 /path/to/code

# test a single sniff only
vendor/bin/snout --standard=Php54to55 --sniffs=Php54to55.Deprecated.Functions /path/to/code
```

# Versioning

The major version reflects PHP_Codesniffer version while minor version reflects the standard revision.

# License

This software is released under the [MIT License](LICENSE).
