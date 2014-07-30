<?php

namespace Php54to55\Sniffs;

use PHP_CodeSniffer_File;

/**
 * Common logic container.
 *
 * @package Php54to55
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
final class Helper
{
    /**
     * Cache for storing last namespace names found in files while
     * parsing them.
     *
     * @var array(string = string)
     */
    protected $lastNamespacesPerFile = array();

    /**
     * Get last namespace.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     *
     * @return string
    */
    public function getLastNamespaceForFile(PHP_CodeSniffer_File $phpcsFile)
    {
        $filename = $phpcsFile->getFilename();
    
        return isset($this->lastNamespacesPerFile[$filename]) ? $this->lastNamespacesPerFile[$filename] : false;
    }

    /**
     * Process namespace.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function processNamespace(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $phpcsFile->findNext(array(T_STRING), ($stackPtr + 1), null, false);
    
        $namspaceToken = $tokens[$token];
        $this->lastNamespacesPerFile[$phpcsFile->getFilename()] = strtolower($namspaceToken['content']);
    }
}
