<?php

require_once dirname(__FILE__) . '/../../bootstrap.php';

/**
 * Forbidden Function Names
 *
 * Searches for global definitions of functions which have been added in
 * PHP 5.5 and would lead to conflicts.
 *
 * A complete list: http://www.php.net/manual/en/migration55.new-functions.php
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @author    Maik Penz // foobugs <maik.penz@foobugs.com>
 * @copyright 2012,2014 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP54to55
 */
class Php54to55_Sniffs_PHP_ForbiddenFunctionNamesSniff extends Foobugs_Standard_AbstractSniff
{
    protected $fooRegisterToken = array(T_STRING);

    protected $functionNameIgnore = array(
        T_WHITESPACE => true,
        T_COMMENT => true,
    );

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $functionName = strtolower($token['content']);

        // continue if string is a function name
        if (!isset($this->fooData[$functionName])) {
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
