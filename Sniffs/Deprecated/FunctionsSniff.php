<?php

/**
 * Deprecated Function Call
 *
 * Checks PHP source files for calls to functions that have been removed in
 * PHP 5.5.
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP54to55
 */
class Php54to55_Sniffs_Deprecated_FunctionsSniff extends Generic_Sniffs_PHP_DeprecatedFunctionsSniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
    );

    /**
     * A list of deprecated functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    protected $forbiddenFunctions = array(
        // core
        'php_logo_guid' => null,
        'php_egg_logo_guid' => null,
        'php_real_logo_guid' => null,
        'zend_logo_guid' => null,

        // mcrypt
        'mcrypt_cbc' => null,
        'mcrypt_cfb' => null,
        'mcrypt_ecb' => null,
        'mcrypt_ofb' => null,

        // deprecated IntlDateFormatter::setTimeZoneID functional interface
        'datefmt_set_timezone_id' => 'use datefmt_set_timezone instead',
    );

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = true;
}
