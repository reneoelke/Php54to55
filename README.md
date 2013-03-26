PHP53to54
===============================================================================
This is a collection of sniffs for [PHP_CodeSniffer](http://pear.php.net/PHP_CodeSniffer) that check an PHP 5.4 application for PHP 5.5 compatibility.

**This project is currently under development**

# Features:
* Check for removed functions

# Detailed
* Removed functions: `php_logo_guid`, `php_egg_logo_guid`, `php_real_logo_guid`, `zend_logo_guid`

# Usage

	composer install
	vendor/bin/phpcs --standard=/Users/ephigenia/Sites/jagger/PHP54to55/ ./test

	vendor/bin/phpcs --standard=/Users/ephigenia/Sites/jagger/PHP54to55 --sniffs=PHP54to55.Deprecated.Functions ./test