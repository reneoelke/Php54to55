<?php

/**
 * Forbidden Class names
 *
 * Searches for definitions of global classes which were added in PHP 5.5.
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

    /**
     * Turn namespace check on/off
     *
     * @var boolean
     */
    public $checkNamespace = true;

    /**
     * Buffer for namespace parsing.
     *
     * @var array(string = string)
     */
    protected $lastNamespacesPerFile = array();

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

    public function __construct()
    {
        // convert human readable to testable format
        $forbiddenClassnames = array();
        foreach ($this->forbiddenClassnames as $cn) {
            $forbiddenClassnames[strtolower($cn)] = $cn;
        }
        $this->forbiddenClassnames = $forbiddenClassnames;
    }

     /** {@inheritdoc} */
    public function register()
    {
        return array(T_CLASS, T_NAMESPACE, T_INTERFACE, T_TRAIT);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the current token in
     * the stack passed in $tokens.
     *
     * @return void
     * @see PHP_CodeSniffer_Sniff::process()
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
    
        $result = true;
        switch ($token['code']) {
            case T_NAMESPACE:
                $result = $this->processNamespace($phpcsFile, $stackPtr);
                break;
            case T_CLASS:
            case T_INTERFACE:
            case T_TRAIT:
            default:
                // only check classnames if we're in global namespace
                if ($this->checkNamespace && isset($this->lastNamespacesPerFile[$phpcsFile->getFilename()])) {
                    break;
                }
                $result = $this->processClass($phpcsFile, $stackPtr);
        }
    }

    /** {@inheritdoc} */
    public function processClass(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // find the name of the defined class
        $nameOfClassStackPtr = $phpcsFile->findNext(array(T_STRING), $stackPtr, null, false);
        if (!$nameOfClassStackPtr) {
            return ;
        }
        $nameOfClassToken = $tokens[$nameOfClassStackPtr];
        $nameOfClass = $nameOfClassToken['content'];

        // check if the class name is forbidden
        $nameOfClass = strtolower($nameOfClass);
        if (isset($this->forbiddenClassnames[$nameOfClass])) {
            $message = sprintf(
                '%s was added in the PHP 5.5 global namespace and can’t be defined',
                $this->forbiddenClassnames[$nameOfClass]
            );
            $phpcsFile->addError($message, $stackPtr);
        }
    }

    /**
     * Process namespace.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the current token in
     * the stack passed in $tokens.
     */
    protected function processNamespace(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $namspaceToken = $tokens[
            $phpcsFile->findNext(array(T_STRING), ($stackPtr + 1), null, false)
        ];
        $this->lastNamespacesPerFile[$phpcsFile->getFilename()] = strtolower($namspaceToken['content']);
    }
}
