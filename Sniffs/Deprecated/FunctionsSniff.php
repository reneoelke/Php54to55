<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Sniffs\Deprecated;

use Generic_Sniffs_PHP_DeprecatedFunctionsSniff;

/**
 * Deprecated Function Call
 *
 * Checks PHP source files for calls to functions that have been removed in
 * PHP 5.5.
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class FunctionsSniff extends Generic_Sniffs_PHP_DeprecatedFunctionsSniff
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
