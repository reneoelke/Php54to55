<?php

namespace FoobugsStandards\Sniffs;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

abstract class AbstractSniff implements PHP_CodeSniffer_Sniff
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
     * Tokens to register for.
     *
     * @var array
     */
    protected $fooRegisterTokens = array();

    /**
     * {@inherited}
     */
    public function register()
    {
        return $this->fooRegisterTokens;
    }

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
    protected function getLastNamespaceForFile(PHP_CodeSniffer_File $phpcsFile)
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
    protected function processNamespace(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $phpcsFile->findNext(array(T_STRING), ($stackPtr + 1), null, false);

        $namspaceToken = $tokens[$token];
        $this->lastNamespacesPerFile[$phpcsFile->getFilename()] = strtolower($namspaceToken['content']);
    }
}
