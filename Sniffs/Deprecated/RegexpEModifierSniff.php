<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Sniffs\Deprecated;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Regexp /e Modifier Sniff
 *
 * Checks for the usage of the /e modifier in strings that appear to be regular
 * expressions.
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class RegexpEModifierSniff implements PHP_CodeSniffer_Sniff
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
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_CONSTANT_ENCAPSED_STRING, T_HEREDOC, T_NOWDOC);
    }

    /**
     * {@inheritdoc}
     */
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
