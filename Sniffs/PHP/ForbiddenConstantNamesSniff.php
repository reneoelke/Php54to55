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
use PHP_CodeSniffer_Tokens;
use FoobugsStandards\Sniffs\AbstractPropertiesSniff;

/**
 * Forbidden Constant Names
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ForbiddenConstantNamesSniff extends AbstractPropertiesSniff
{
    /**
     * Turn namespace checking on/off
     *
     * @var boolean
     */
    public $checkNamespace = true;

    protected $fooRegisterTokens = array(
        T_STRING,
        T_NAMESPACE,
    );

    /**
     * {@inherited}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        switch($token['code']) {
            case T_NAMESPACE:
                $this->processNamespace($phpcsFile, $stackPtr);
                break;
            case T_STRING:
            default:
                if ($this->checkNamespace
                    && $this->getLastNamespaceForFile($phpcsFile)
                ) {
                    break;
                }
                if (strtolower($token['content']) !== 'define') {
                    break;
                }
                $this->processConstantDefinition($phpcsFile, $stackPtr);
                break;
        }
    }

    /**
     * Process constant definition.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    protected function processConstantDefinition(
        PHP_CodeSniffer_File $phpcsFile,
        $stackPtr
    ) {
        $tokens = $phpcsFile->getTokens();

        $openBracket = $phpcsFile->findNext(
            PHP_CodeSniffer_Tokens::$emptyTokens,
            $stackPtr + 1,
            null,
            true
        );
        if ($openBracket == false) {
            return false;
        }
        $firstParameterPtr = $phpcsFile->findNext(
            PHP_CodeSniffer_Tokens::$emptyTokens,
            $openBracket + 1,
            null,
            true
        );
        if ($firstParameterPtr == false) {
            return false;
        }

        // define($var, 'foobar') raises warning
        if ($tokens[$firstParameterPtr]['code'] == T_VARIABLE) {
            $phpcsFile->addWarning(
                sprintf('constant definition with variable could be forbidden'),
                $firstParameterPtr,
                'possibleInvalidConstantName'
            );

            return false;
        }
        if ($tokens[$firstParameterPtr]['code'] != T_CONSTANT_ENCAPSED_STRING) {
            return false;
        }

        // define('string', 'foobar') check for invalid string
        $firstParameterValue = substr($tokens[$firstParameterPtr]['content'], 1, -1);
        if (isset(static::$fooProperties[$firstParameterValue])) {
            $phpcsFile->addError(
                sprintf(
                    '%s is an invalid name for a constant',
                    $firstParameterValue
                ),
                $firstParameterPtr,
                'invalidConstantName'
            );
        }

        return false;
    }
}
