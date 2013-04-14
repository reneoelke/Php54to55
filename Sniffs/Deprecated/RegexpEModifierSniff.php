<?php

namespace Php54to55\Sniffs\Deprecated;

/**
 * Regexp /e Modifier Sniff
 *
 * Checks for the usage of the /e modifier in strings that appear to be regular
 * expressions.
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP53to54
 */
class RegexpEModifierSniff extends \PHP54to55\AbstractSniff
{
    /** {@inheritdoc} */
    public $supportedTokenizers = array(
        'PHP',
    );

    /** {@inheritdoc} */
    public function register()
    {
        return array(T_CONSTANT_ENCAPSED_STRING);
    }

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $stringValue = substr($token['content'], 1, -1);
        // check if it’s a regexp and uses the e modifier
        if (preg_match('/^(.{1}).+\1e$/', $stringValue)) {
            $phpcsFile->addError(
                'The "/e" modifier is deprecated in PHP 5.5. You should use preg_replace_callback() instead.',
                $stackPtr
            );
        }
    }
}
