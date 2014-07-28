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
use FoobugsStandards\Sniffs\AbstractPropertiesSniff;

/**
 * Forbidden Function Names
 *
 * Searches for global definitions of functions which have been added in
 * PHP 5.5 and would lead to conflicts.
 *
 * A complete list: http://www.php.net/manual/en/migration55.new-functions.php
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ForbiddenFunctionNamesSniff extends AbstractPropertiesSniff
{
    /**
     * @var array
     */
    protected $functionNameIgnore = array(
        T_WHITESPACE => true,
        T_COMMENT => true,
    );

    protected $fooRegisterTokens = array(
        T_STRING,
    );

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $functionName = strtolower($token['content']);

        // continue if string is a function name
        if (!isset(static::$fooProperties[$functionName])) {
            return true;
        }

        // check if it’s a global method by simply checking the level
        if ($token['level'] !== 0) {
            return true;
        }

        // check if it is a function definition
        if ($stackPtr <= 2) {
            return false;
        }

        // there may be some tokens between T_FUNCTION and function name: skip those
        $stackPtrIterator = $stackPtr-2;
        while ($stackPtrIterator > 1 && isset($this->functionNameIgnore[$tokens[$stackPtrIterator]['code']])) {
            $stackPtrIterator--;
        }
        if ($tokens[$stackPtrIterator]['type'] != 'T_FUNCTION') {
            return true;
        }

        $message = sprintf(
            '%s is allready a global function defined in PHP %s',
            $functionName,
            $this->fooLabel[$functionName]
        );
        $phpcsFile->addError($message, $stackPtr, 'forbiddenFunctionDefintion');
    }
}
