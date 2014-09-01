<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Sniffs\PHP;

use PHP_CodeSniffer_File;
use Php54to55\Sniffs\SniffBase;

/**
 * Changed Return Values
 *
 * Searches for functions / methods that changed the return value.
 * See http://php.net/manual/en/migration55.changed-functions.php
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ChangedReturnValuesSniff extends SniffBase
{
    protected $fooRegisterTokens = array(
        T_STRING,
    );

    protected $fooProperties = array(
        // PHP 5.5.0
        // core
        'set_error_handler' => '%s() now returns previous error handler if passed with NULL!',
        'set_exception_handler' => '%s() now returns previous exception handler instead of TRUE if passed with NULL!',
    );

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr]['content'];

        if (isset($this->fooProperties[$token])) {
            $message = sprintf(
                $this->fooProperties[$token],
                $token
            );
            $phpcsFile->addWarning($message, $stackPtr);
        }
    }
}
