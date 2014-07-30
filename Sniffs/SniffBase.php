<?php

namespace Php54to55\Sniffs;

use PHP_CodeSniffer_Sniff;

/**
 *
 */
abstract class SniffBase implements PHP_CodeSniffer_Sniff
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
     * Tokens to register for.
     *
     * @var array
    */
    protected $fooRegisterTokens = array();

    /**
     * Helpful method with proper scope.
     *
     * @var Helper
     */
    protected $foo;

    /**
     * {@inherited}
     */
    public function register()
    {
        if (!isset($this->foo)) {
            $this->foo = new Helper();
        }

        return $this->fooRegisterTokens;
    }
}
