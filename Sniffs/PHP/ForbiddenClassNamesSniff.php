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

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Forbidden Class names
 *
 * Searches for definitions of global classes which were added in PHP 5.5.
 * A complete list: http://www.php.net/manual/en/migration55.classes.php
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ForbiddenClassNamesSniff implements PHP_CodeSniffer_Sniff
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
     * Turn namespace check on/off
     *
     * @var boolean
     */
    public $checkNamespace = true;

    /**
     * Buffer for namespace parsing.
     *
     * @var array(string = string)
     */
    protected $lastNamespacesPerFile = array();

    /**
     * A list of forbidden function names
     *
     * @var array(string => array(string, [string]))
     */
    protected $forbiddenClassnames = array(
        // intl
        'IntlCalendar',
        'IntlGregorianCalendar',
        'IntlTimeZone',
        'IntlBreakIterator',
        'IntlRuleBasedBreakIterator',
        'IntlCodePointBreakIterator',

        // DateTime
        'DateTimeImmutable',

        // curl
        'CURLFile',
    );

    /**
     * Constructor.
     */
    public function __construct()
    {
        // convert human readable to testable format
        $forbiddenClassnames = array();
        foreach ($this->forbiddenClassnames as $cn) {
            $forbiddenClassnames[strtolower($cn)] = $cn;
        }
        $this->forbiddenClassnames = $forbiddenClassnames;
    }

     /**
      * {@inheritdoc}
      */
    public function register()
    {
        return array(
            T_CLASS,
            T_NAMESPACE,
            T_INTERFACE,
            T_TRAIT,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
    
        $result = true;
        switch ($token['code']) {
            case T_NAMESPACE:
                $this->processNamespace($phpcsFile, $stackPtr);
                break;
            case T_CLASS:
            case T_INTERFACE:
            case T_TRAIT:
            default:
                // only check classnames if we're in global namespace
                if ($this->checkNamespace && isset($this->lastNamespacesPerFile[$phpcsFile->getFilename()])) {
                    break;
                }
                $this->processClass($phpcsFile, $stackPtr);
        }
    }


    /**
     * Process class.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return $this
     */
    public function processClass(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // find the name of the defined class
        $nameOfClassStackPtr = $phpcsFile->findNext(array(T_STRING), $stackPtr, null, false);
        if (!$nameOfClassStackPtr) {
            return $this;
        }
        $nameOfClassToken = $tokens[$nameOfClassStackPtr];
        $nameOfClass = $nameOfClassToken['content'];

        // check if the class name is forbidden
        $nameOfClass = strtolower($nameOfClass);
        if (isset($this->forbiddenClassnames[$nameOfClass])) {
            $message = sprintf(
                '%s was added in the PHP 5.5 global namespace and can’t be defined',
                $this->forbiddenClassnames[$nameOfClass]
            );
            $phpcsFile->addError($message, $stackPtr);
        }

        return $this;
    }

    /**
     * Process namespace.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return $this
     */
    protected function processNamespace(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $namspaceToken = $tokens[
            $phpcsFile->findNext(array(T_STRING), ($stackPtr + 1), null, false)
        ];
        $this->lastNamespacesPerFile[$phpcsFile->getFilename()] = strtolower($namspaceToken['content']);

        return $this;
    }
}
