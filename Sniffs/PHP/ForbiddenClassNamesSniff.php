<?php

/**
 * Forbidden Class names
 *
 * Searches for definitions of global classes which were added in PHP 5.4.
 * A complete list: http://www.php.net/manual/en/migration55.classes.php
 *
 * @package   PHP_CodeSniffer
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @author    Maik Penz // foobugs <maik.penz@foobugs.com>
 * @copyright 2012,2014 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP54to55
 */
class Php54to55_Sniffs_PHP_ForbiddenClassNamesSniff implements PHP_CodeSniffer_Sniff
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

    public function __construct()
    {
        // convert human readable to testable format
        $forbiddenClassnames = array();
        foreach ($this->forbiddenClassnames as $cn) {
            $forbiddenClassnames[strtolower($cn)] = true;
        }
    }

    /**
     * A list of forbidden function names
     *
     * @var array(string => array(string, [string]))
     */
    protected $forbiddenClassnames = array(
        // intl
        'IntlCalendar',
        'IntlGregorianCalendar',
        'IntlTimeZone',
        'IntlBreakIterator',
        'IntlRuleBasedBreakIterator',
        'IntlCodePointBreakIterator',

        // DateTime
        'DateTimeImmutable',

        // curl
        'CURLFile',
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
        if (isset($this->forbiddenClassnames[$nameOfClass])) {
            $message = sprintf(
                '%s was added in the PHP 5.5 global namespace and can’t be defined',
                $forbiddenClassname
            );
            $phpcsFile->addError($message, $stackPtr);
        }
    }
}
