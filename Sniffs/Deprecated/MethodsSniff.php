<?php

namespace Php54to55\Sniffs\Deprecated;

use PHP_CodeSniffer_File;

/**
 * Deprecated Method Sniff
 *
 * This sniff searches for calls to deprecated methods. It adds warnings if
 * a method is called which is listed in $forbiddenMethods.
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP53to54
 */
class MethodsSniff extends \PHP54to55\AbstractSniff
{
    /** {@inheritdoc} */
    public $supportedTokenizers = array(
        'PHP',
    );

    /** @deprecated **/
    protected $forbiddenMethods = array(
        // method names should be lowercase because calls to methods
        // are case-insensitive in php
        'settimezoneid' => array(
            'class' => 'IntlDateFormatter',
        )
    );

    /** {@inheritdoc} */
    public function register()
    {
        return array(
            T_STRING,
            T_OBJECT_OPERATOR,
        );
    }

    protected $lastObjectOperatorToken;

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        switch($token['type']) {
            case 'T_OBJECT_OPERATOR':
                $this->lastObjectOperatorToken = $token;
                break;
            case 'T_STRING':
                $possibleMethodName = strtolower($token['content']);
                // do nothing if string is not a method in the list
                if (!isset($this->forbiddenMethods[$possibleMethodName])) {
                    return ;
                }
                // do nothing if no last object operator token
                if (!isset($this->lastObjectOperatorToken)) {
                    return ;
                }
                // check if last object operator is in front of the method string
                $message = sprintf(
                    '%2$s::%1$s is deprecated, please check if call is on an instance of %2$s',
                    $possibleMethodName,
                    $this->forbiddenMethods[$possibleMethodName]['class']
                );
                $phpcsFile->addWarning(
                    $message,
                    $stackPtr,
                    'Deprecated'
                );
        }
    }
}
