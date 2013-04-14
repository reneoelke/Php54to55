<?php

namespace Php54to55\Sniffs\PHP;

use PHP_CodeSniffer_File;

/**
 * Forbidden Class names
 *
 * Searches for definitions of global classes which were added in PHP 5.4.
 * A complete list: http://www.php.net/manual/en/migration55.classes.php
 *
 * @package   PHP_CodeSniffer
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @copyright 2012 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP53to54
 */
class ForbiddenClassNamesSniff extends \PHP54to55\AbstractSniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
    );

    /** {@inheritdoc} */
    public function register()
    {
        return array(
            T_CLASS,
        );
    }

    /**
     * A list of forbidden function names
     *
     * @var array(string => array(string, [string]))
     */
    protected $forbiddenClassnames = array(
        'IntlCalendar',
        'IntlGregorianCalendar',
        'IntlTimeZone',
        'IntlBreakIterator',
        'IntlRuleBasedBreakIterator',
        'IntlCodePointBreakIterator',
    );

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // find the name of the defined class
        $nameOfClassStackPtr = $phpcsFile->findNext(array(T_STRING), $stackPtr, null, false);
        if (!$nameOfClassStackPtr) {
            return true;
        }
        $nameOfClassToken = $tokens[$nameOfClassStackPtr];
        $nameOfClass = $nameOfClassToken['content'];

        // check if the class name is forbidden
        $nameOfClass = strtolower($nameOfClass);
        foreach ($this->forbiddenClassnames as $forbiddenClassname) {

            if (strtolower($forbiddenClassname) == $nameOfClass) {
                $message = sprintf(
                    '%s was added in PHP 5.5 the global namespace and can’t be defined',
                    $forbiddenClassname
                );
                $phpcsFile->addError($message, $stackPtr);
            }
        }
    }
}
