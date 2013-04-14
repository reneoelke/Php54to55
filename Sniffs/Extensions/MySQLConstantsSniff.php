<?php

namespace Php54to55\Sniffs\Extensions;

use PHP_CodeSniffer_File;

/**
 * Deprecated MySQL Constants Sniff
 *
 * Searches for constants provided by the mysql extension which was removed
 * in PHP 5.5
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP53to54
 */
class MySQLConstantsSniff extends \Php54to55\AbstractSniff
{
    /** {@inheritdoc} */
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

    /** {@inheritdoc} */
    public function register()
    {
        return array(T_STRING, );
    }

    /** {@inheritdoc} */
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
