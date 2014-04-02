<?php

require_once dirname(__FILE__) . '/../../bootstrap.php';

/**
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Maik Penz // foobugs <maik.penz@foobugs.com>
 * @copyright 2014 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/Php54to55
 */
class Php54to55_Sniffs_PHP_ReservedKeywordsSniff extends Foobugs_Standard_AbstractSniff
{
    protected $fooRegisterToken = array(
        T_DIR,
        T_GOTO,
        T_NAMESPACE,
        T_NS_C,
        T_STRING,
        T_USE,
    );

    /**
     * List with reserved PHP keywords.
     *
     * @var array
     */
    private $keywords = array(
        'finally' => false,
    );

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     * @see PHP_CodeSniffer_Sniff::process()
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr]['content'];

        if (isset($this->keywords[$token])) {
            $error = sprintf(
                'Use of reserved keyword "%s"!',
                $token
            );
            $phpcsFile->addError($error, $stackPtr);
        }

        return true;
    }
}
