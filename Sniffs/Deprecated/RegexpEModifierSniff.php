<?php

/**
 * Removed Function Aliases Test
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP53to54
 * @since     1.0-beta
 */

/**
 * Deprecated Function Call
 *
 * Checks PHP source files for calls to functions that have been removed in
 * PHP 5.5.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP53to54
 * @since     1.0-beta
 */
class PHP54to55_Sniffs_Deprecated_RegexpEModifierSniff
extends PHP54to55_AbstractSniff
{
    /** @inheritdoc */
    public $supportedTokenizers = array(
        'PHP',
    );

    /** @inheritdoc */
    public function register()
    {
        return array(T_CONSTANT_ENCAPSED_STRING);
    }

    /** @inheritdoc */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $stringValue = substr($token['content'], 1, -1);
        // check if it’s a regexp and uses the e modifier
        if (preg_match('/^(.{1}).+\1e$/', $stringValue)) {
            $phpcsFile->addError(
                'The usage of the "/e" modifier is deprecated in PHP 5.4. You should use preg_replace_callback() instead.',
                $stackPtr,
                'ErrorRegexpWithEModifier'
            );
        }
        
        return true;
    }
}