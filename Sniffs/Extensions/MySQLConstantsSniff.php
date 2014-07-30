<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Sniffs\Extensions;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Tokens;

/**
 * Deprecated MySQL Constants Sniff
 *
 * Searches for constants provided by the mysql extension which was removed
 * in PHP 5.5
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class MySQLConstantsSniff implements PHP_CodeSniffer_Sniff
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
     * List of constants added by SQLite extension in PHP 5.4.
     *
     * @var array
     */
    protected $constants = array(
        'MYSQL_CLIENT_COMPRESS',
        'MYSQL_CLIENT_IGNORE_SPACE',
        'MYSQL_CLIENT_INTERACTIVE',
        'MYSQL_CLIENT_SSL',
        'MYSQL_ASSOC',
        'MYSQL_BOTH',
        'MYSQL_NUM',
    );

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_STRING, );
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $constantName = $token['content'];

        // check if constant name is registered in the list of invalid names
        if (!in_array($constantName, $this->constants)) {
            return ;
        }

        // check if its a constant definition in a class
        $previousNotEmptyToken = $phpcsFile->findPrevious(
            PHP_CodeSniffer_Tokens::$emptyTokens,
            $stackPtr - 1,
            null,
            true
        );
        $previousToken = $tokens[$previousNotEmptyToken];
        if ($previousToken['code'] == T_CONST) {
            return ;
        }

        $phpcsFile->addError(
            sprintf(
                '%s from the mysql extension is not supported by PHP 5.5 anymore',
                $token['content']
            ),
            $stackPtr
        );
    }
}
