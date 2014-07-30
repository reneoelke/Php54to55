<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Sniffs\PHP;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Reserved Keywords
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ReservedKeywordsSniff implements PHP_CodeSniffer_Sniff
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
     * List with reserved PHP keywords.
     *
     * @var array
     */
    protected $keywords = array(
        'finally' => false,
    );

    /**
     * {@inherited}
     */
    public function register()
    {
        return array(
            T_DIR,
            T_GOTO,
            T_NAMESPACE,
            T_NS_C,
            T_STRING,
            T_USE,
        );
    }

    /**
     * {@inherited}
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
    }
}
