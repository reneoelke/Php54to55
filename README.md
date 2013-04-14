PHP53to54
===============================================================================
This is a collection of sniffs for [PHP_CodeSniffer](http://pear.php.net/PHP_CodeSniffer) that check an PHP 5.4 application for PHP 5.5 compatibility.

**This project is currently under development**

[![Build Status](https://secure.travis-ci.org/goatherd/Php54to55.png?branch=next-gen)](https://travis-ci.org/goatherd/Php54to55)

# Features:
* Check for deprecated & removed functions (MySQL, mycrypt_*)
* Check for `/e` modifier in regular expressions
* Check for removed Constants (MySQL)
* Check for `setTimeZoneID` or `datefmt_set_timezone_id` usage
* Check for definitions of global functions which are [new in PHP 5.5](http://www.php.net/manual/en/migration55.new-functions.php)
* Check for definitions of classes that have been added in PHP 5.5

[Detailed feature list](FEATURES.md).

# Usage

	composer install
	vendor/bin/phpcs --standard=php54to55/ ./test

	vendor/bin/phpcs --standard=php54to55 --sniffs=Php54to55.Deprecated.Functions ./test
