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
class ForbiddenClassNamesSniff extends SniffBase
{
    /**
     * Turn namespace check on/off
     *
     * @var boolean
     */
    public $checkNamespace = true;

    protected $fooRegisterTokens = array(
        T_CLASS,
        T_NAMESPACE,
        T_INTERFACE,
        T_TRAIT,
    );

    protected $fooProperties = array(
        // PHP 5.5.0
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

    public function __construct()
    {
        // normalise for processing and reporting
        foreach ($this->fooProperties as $k => $v) {
            unset($this->fooProperties[$k]);
            $this->fooProperties[strtolower($v)] = $v;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
    
        switch ($token['code']) {
            case T_NAMESPACE:
                $this->foo->processNamespace($phpcsFile, $stackPtr);
                break;
            case T_CLASS:
            case T_INTERFACE:
            case T_TRAIT:
            default:
                // only check classnames if we're in global namespace
                if ($this->checkNamespace && $this->foo->getLastNamespaceForFile($phpcsFile)) {
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

        // find the name of the defined class
        $nameOfClassStackPtr = $phpcsFile->findNext(array(T_STRING), $stackPtr, null, false);
        if (!$nameOfClassStackPtr) {
            return $this;
        }
        $nameOfClassToken = $tokens[$nameOfClassStackPtr];
        $nameOfClass = $nameOfClassToken['content'];

        // check if the class name is forbidden
        $nameOfClass = strtolower($nameOfClass);
        if (isset($this->fooProperties[$nameOfClass])) {
            $message = sprintf(
                '%s was added in the PHP 5.5 global namespace and can’t be defined',
                $this->fooProperties[$nameOfClass]
            );
            $phpcsFile->addError($message, $stackPtr);
        }

        return $this;
    }
}
