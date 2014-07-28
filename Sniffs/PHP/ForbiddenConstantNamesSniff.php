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
use PHP_CodeSniffer_Tokens;

/**
 * Forbidden Constant Names
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ForbiddenConstantNamesSniff implements PHP_CodeSniffer_Sniff
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
     * A list of forbidden constant names.
     *
     * @var array(string => TRUE)
     */
    public $names = array(
        // 5.5.0
        'CURLOPT_FTP_RESPONSE_TIMEOUT' => true,
        'CURLOPT_APPEND' => true,
        'CURLOPT_DIRLISTONLY' => true,
        'CURLOPT_NEW_DIRECTORY_PERMS' => true,
        'CURLOPT_NEW_FILE_PERMS' => true,
        'CURLOPT_NETRC_FILE' => true,
        'CURLOPT_PREQUOTE' => true,
        'CURLOPT_KRBLEVEL' => true,
        'CURLOPT_MAXFILESIZE' => true,
        'CURLOPT_FTP_ACCOUNT' => true,
        'CURLOPT_COOKIELIST' => true,
        'CURLOPT_IGNORE_CONTENT_LENGTH' => true,
        'CURLOPT_CONNECT_ONLY' => true,
        'CURLOPT_LOCALPORT' => true,
        'CURLOPT_LOCALPORTRANGE' => true,
        'CURLOPT_FTP_ALTERNATIVE_TO_USER' => true,
        'CURLOPT_SSL_SESSIONID_CACHE' => true,
        'CURLOPT_FTP_SSL_CCC' => true,
        'CURLOPT_HTTP_CONTENT_DECODING' => true,
        'CURLOPT_HTTP_TRANSFER_DECODING' => true,
        'CURLOPT_PROXY_TRANSFER_MODE' => true,
        'CURLOPT_ADDRESS_SCOPE' => true,
        'CURLOPT_CRLFILE' => true,
        'CURLOPT_ISSUERCERT' => true,
        'CURLOPT_USERNAME' => true,
        'CURLOPT_PASSWORD' => true,
        'CURLOPT_PROXYUSERNAME' => true,
        'CURLOPT_PROXYPASSWORD' => true,
        'CURLOPT_NOPROXY' => true,
        'CURLOPT_SOCKS5_GSSAPI_NEC' => true,
        'CURLOPT_SOCKS5_GSSAPI_SERVICE' => true,
        'CURLOPT_TFTP_BLKSIZE' => true,
        'CURLOPT_SSH_KNOWNHOSTS' => true,
        'CURLOPT_FTP_USE_PRET' => true,
        'CURLOPT_MAIL_FROM' => true,
        'CURLOPT_MAIL_RCPT' => true,
        'CURLOPT_RTSP_CLIENT_CSEQ' => true,
        'CURLOPT_RTSP_SERVER_CSEQ' => true,
        'CURLOPT_RTSP_SESSION_ID' => true,
        'CURLOPT_RTSP_STREAM_URI' => true,
        'CURLOPT_RTSP_TRANSPORT' => true,
        'CURLOPT_RTSP_REQUEST' => true,
        'CURLOPT_RESOLVE' => true,
        'CURLOPT_ACCEPT_ENCODING' => true,
        'CURLOPT_TRANSFER_ENCODING' => true,
        'CURLOPT_DNS_SERVERS' => true,
        'CURLOPT_USE_SSL' => true,
        'CURLOPT_TELNETOPTIONS' => true,
        'CURLOPT_GSSAPI_DELEGATION' => true,
        'CURLOPT_ACCEPTTIMEOUT_MS' => true,
        'CURLOPT_SSL_OPTIONS' => true,
        'CURLOPT_TCP_KEEPALIVE' => true,
        'CURLOPT_TCP_KEEPIDLE' => true,
        'CURLOPT_TCP_KEEPINTVL' => true,

        // GD
        'IMG_AFFINE_TRANSLATE' => true,
        'IMG_AFFINE_SCALE' => true,
        'IMG_AFFINE_ROTATE' => true,
        'IMG_AFFINE_SHEAR_HORIZONTAL' => true,
        'IMG_AFFINE_SHEAR_VERTICAL' => true,
        'IMG_CROP_DEFAULT' => true,
        'IMG_CROP_TRANSPARENT' => true,
        'IMG_CROP_BLACK' => true,
        'IMG_CROP_WHITE' => true,
        'IMG_CROP_SIDES' => true,
        'IMG_FLIP_BOTH' => true,
        'IMG_FLIP_HORIZONTAL' => true,
        'IMG_FLIP_VERTICAL' => true,
        'IMG_BELL' => true,
        'IMG_BESSEL' => true,
        'IMG_BICUBIC' => true,
        'IMG_BICUBIC_FIXED' => true,
        'IMG_BLACKMAN' => true,
        'IMG_BOX' => true,
        'IMG_BSPLINE' => true,
        'IMG_CATMULLROM' => true,
        'IMG_GAUSSIAN' => true,
        'IMG_GENERALIZED_CUBIC' => true,
        'IMG_HERMITE' => true,
        'IMG_HAMMING' => true,
        'IMG_HANNING' => true,
        'IMG_MITCHELL' => true,
        'IMG_POWER' => true,
        'IMG_QUADRATIC' => true,
        'IMG_SINC' => true,
        'IMG_NEAREST_NEIGHBOUR' => true,
        'IMG_WEIGHTED4' => true,
        'IMG_TRIANGLE' => true,

        // json
        'JSON_ERROR_RECURSION' => true,
        'JSON_ERROR_INF_OR_NAN' => true,
        'JSON_ERROR_UNSUPPORTED_TYPE' => true,

        // mysqli
        'MYSQLI_SERVER_PUBLIC_KEY' => true,

        // 5.5.1
        'PHP_FCGI_BACKLOG' => true,

        // 5.5.2
        'LIBXML_SCHEMA_CREATE' => true,
    );

    /**
     * Cache for storing last namespace names found in files while
     * parsing them.
     *
     * @var array(string = string)
     */
    protected $lastNamespacesPerFile = array();

    /**
     * Turn namespace checking on/off
     *
     * @var boolean
     */
    public $checkNamespace = true;

    /**
     * {@inherited}
     */
    public function register()
    {
        return array(
            T_STRING,
            T_NAMESPACE,
        );
    }

    /**
     * {@inherited}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        switch($token['code']) {
            case T_NAMESPACE:
                $this->processNamespace($phpcsFile, $stackPtr);
                break;
            case T_STRING:
            default:
                if ($this->checkNamespace
                    && $this->getLastNamespaceForFile($phpcsFile)
                ) {
                    break;
                }
                if (strtolower($token['content']) !== 'define') {
                    break;
                }
                $this->processConstantDefinition($phpcsFile, $stackPtr);
                break;
        }
    }

    /**
     * Get last namespace.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @return string
     */
    protected function getLastNamespaceForFile(PHP_CodeSniffer_File $phpcsFile)
    {
        $filename = $phpcsFile->getFilename();
        if (!isset($this->lastNamespacesPerFile[$filename])) {
            return false;
        }
        return $this->lastNamespacesPerFile[$filename];
    }

    /**
     * Process namespace.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    protected function processNamespace(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $namspaceToken = $tokens[
            $phpcsFile->findNext(array(T_STRING), ($stackPtr + 1), null, false)
        ];
        $this->lastNamespacesPerFile[$phpcsFile->getFilename()]
            = strtolower($namspaceToken['content']);
        return true;
    }

    /**
     * Process constant definition.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    protected function processConstantDefinition(
        PHP_CodeSniffer_File $phpcsFile,
        $stackPtr
    ) {
        $tokens = $phpcsFile->getTokens();

        $openBracket = $phpcsFile->findNext(
            PHP_CodeSniffer_Tokens::$emptyTokens,
            $stackPtr + 1,
            null,
            true
        );
        if ($openBracket == false) {
            return false;
        }
        $firstParameterPtr = $phpcsFile->findNext(
            PHP_CodeSniffer_Tokens::$emptyTokens,
            $openBracket + 1,
            null,
            true
        );
        if ($firstParameterPtr == false) {
            return false;
        }

        // define($var, 'foobar') raises warning
        if ($tokens[$firstParameterPtr]['code'] == T_VARIABLE) {
            $phpcsFile->addWarning(
                sprintf('constant definition with variable could be forbidden'),
                $firstParameterPtr,
                'possibleInvalidConstantName'
            );

            return false;
        }
        if ($tokens[$firstParameterPtr]['code'] != T_CONSTANT_ENCAPSED_STRING) {
            return false;
        }

        // define('string', 'foobar') check for invalid string
        $firstParameterValue = substr($tokens[$firstParameterPtr]['content'], 1, -1);
        if (isset($this->names[$firstParameterValue])) {
            $phpcsFile->addError(
                sprintf(
                    '%s is an invalid name for a constant',
                    $firstParameterValue
                ),
                $firstParameterPtr,
                'invalidConstantName'
            );
        }

        return false;
    }
}
