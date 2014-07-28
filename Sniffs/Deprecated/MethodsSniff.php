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

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Deprecated Method Sniff
 *
 * This sniff searches for calls to deprecated methods. It adds warnings if
 * a method is called which is listed in $forbiddenMethods.
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class MethodsSniff implements PHP_CodeSniffer_Sniff
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
     * @deprecated
     */
    protected $forbiddenMethods = array(
        // method names should be lowercase because calls to methods
        // are case-insensitive in php
        'settimezoneid' => array(
            'class' => 'IntlDateFormatter',
        )
    );

    /**
     * @var string
     */
    protected $lastObjectOperatorToken;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(
            T_STRING,
            T_OBJECT_OPERATOR,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        switch($token['type']) {
            case 'T_OBJECT_OPERATOR':
                $this->lastObjectOperatorToken = $token;
                break;
            case 'T_STRING':
                $possibleMethodName = strtolower($token['content']);
                // do nothing if string is not a method in the list
                if (!isset($this->forbiddenMethods[$possibleMethodName])) {
                    return ;
                }
                // do nothing if no last object operator token
                if (!isset($this->lastObjectOperatorToken)) {
                    return ;
                }
                // check if last object operator is in front of the method string
                $message = sprintf(
                    '%2$s::%1$s is deprecated, please check if call is on an instance of %2$s',
                    $possibleMethodName,
                    $this->forbiddenMethods[$possibleMethodName]['class']
                );
                $phpcsFile->addWarning(
                    $message,
                    $stackPtr,
                    'Deprecated'
                );
                break;
            default:
                break;
        }
    }
}
