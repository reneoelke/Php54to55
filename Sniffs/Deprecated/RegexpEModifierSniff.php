<?php

/**
 * Regexp /e Modifier Sniff
 *
 * Checks for the usage of the /e modifier in strings that appear to be regular
 * expressions.
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP54to55
 */
class Php54to55_Sniffs_Deprecated_RegexpEModifierSniff implements PHP_CodeSniffer_Sniff
{
    /** {@inheritdoc} */
    public $supportedTokenizers = array(
        'PHP',
    );

    /** {@inheritdoc} */
    public function register()
    {
        return array(T_CONSTANT_ENCAPSED_STRING, T_HEREDOC, T_NOWDOC);
    }

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        if ($tokens[$stackPtr]['code'] === T_CONSTANT_ENCAPSED_STRING) {
            $stringValue = substr($token['content'], 1, -1);
        } else {
            $stringValue = trim($token['content']);
        }

        // check if it’s a regexp and uses the e modifier
        // note: A delimiter can be any non-alphanumeric, non-backslash, non-whitespace character.
        $modifiers = 'imsuxADJSUX';
        $regex = sprintf('/^([^\pL\pN\s\pZ\\\\])(?:[^\\\\]|[\\\\](?!=\1))+\1[%s]*e[%s]*$/u', $modifiers, $modifiers);
        if (preg_match($regex, $stringValue, $match) === 1) {
            // remove some false positives
            #var_dump($stringValue, $match);
            $phpcsFile->addWarning(
                'The "/e" modifier is deprecated in PHP 5.5. You should use preg_replace_callback() instead.',
                $stackPtr
            );
        }
    }
}
