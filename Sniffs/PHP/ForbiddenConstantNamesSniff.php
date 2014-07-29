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

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Tokens;
use Php54to55\Sniffs\SniffBase;

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
class ForbiddenConstantNamesSniff extends SniffBase
{
    /**
     * Turn namespace checking on/off
     *
     * @var boolean
     */
    public $checkNamespace = true;

    protected $fooRegisterTokens = array(
        T_STRING,
        T_NAMESPACE,
    );

    protected $fooProperties = array(
        // 5.5.0
        'CURLOPT_FTP_RESPONSE_TIMEOUT',
        'CURLOPT_APPEND',
        'CURLOPT_DIRLISTONLY',
        'CURLOPT_NEW_DIRECTORY_PERMS',
        'CURLOPT_NEW_FILE_PERMS',
        'CURLOPT_NETRC_FILE',
        'CURLOPT_PREQUOTE',
        'CURLOPT_KRBLEVEL',
        'CURLOPT_MAXFILESIZE',
        'CURLOPT_FTP_ACCOUNT',
        'CURLOPT_COOKIELIST',
        'CURLOPT_IGNORE_CONTENT_LENGTH',
        'CURLOPT_CONNECT_ONLY',
        'CURLOPT_LOCALPORT',
        'CURLOPT_LOCALPORTRANGE',
        'CURLOPT_FTP_ALTERNATIVE_TO_USER',
        'CURLOPT_SSL_SESSIONID_CACHE',
        'CURLOPT_FTP_SSL_CCC',
        'CURLOPT_HTTP_CONTENT_DECODING',
        'CURLOPT_HTTP_TRANSFER_DECODING',
        'CURLOPT_PROXY_TRANSFER_MODE',
        'CURLOPT_ADDRESS_SCOPE',
        'CURLOPT_CRLFILE',
        'CURLOPT_ISSUERCERT',
        'CURLOPT_USERNAME',
        'CURLOPT_PASSWORD',
        'CURLOPT_PROXYUSERNAME',
        'CURLOPT_PROXYPASSWORD',
        'CURLOPT_NOPROXY',
        'CURLOPT_SOCKS5_GSSAPI_NEC',
        'CURLOPT_SOCKS5_GSSAPI_SERVICE',
        'CURLOPT_TFTP_BLKSIZE',
        'CURLOPT_SSH_KNOWNHOSTS',
        'CURLOPT_FTP_USE_PRET',
        'CURLOPT_MAIL_FROM',
        'CURLOPT_MAIL_RCPT',
        'CURLOPT_RTSP_CLIENT_CSEQ',
        'CURLOPT_RTSP_SERVER_CSEQ',
        'CURLOPT_RTSP_SESSION_ID',
        'CURLOPT_RTSP_STREAM_URI',
        'CURLOPT_RTSP_TRANSPORT',
        'CURLOPT_RTSP_REQUEST',
        'CURLOPT_RESOLVE',
        'CURLOPT_ACCEPT_ENCODING',
        'CURLOPT_TRANSFER_ENCODING',
        'CURLOPT_DNS_SERVERS',
        'CURLOPT_USE_SSL',
        'CURLOPT_TELNETOPTIONS',
        'CURLOPT_GSSAPI_DELEGATION',
        'CURLOPT_ACCEPTTIMEOUT_MS',
        'CURLOPT_SSL_OPTIONS',
        'CURLOPT_TCP_KEEPALIVE',
        'CURLOPT_TCP_KEEPIDLE',
        'CURLOPT_TCP_KEEPINTVL',

        // GD
        'IMG_AFFINE_TRANSLATE',
        'IMG_AFFINE_SCALE',
        'IMG_AFFINE_ROTATE',
        'IMG_AFFINE_SHEAR_HORIZONTAL',
        'IMG_AFFINE_SHEAR_VERTICAL',
        'IMG_CROP_DEFAULT',
        'IMG_CROP_TRANSPARENT',
        'IMG_CROP_BLACK',
        'IMG_CROP_WHITE',
        'IMG_CROP_SIDES',
        'IMG_FLIP_BOTH',
        'IMG_FLIP_HORIZONTAL',
        'IMG_FLIP_VERTICAL',
        'IMG_BELL',
        'IMG_BESSEL',
        'IMG_BICUBIC',
        'IMG_BICUBIC_FIXED',
        'IMG_BLACKMAN',
        'IMG_BOX',
        'IMG_BSPLINE',
        'IMG_CATMULLROM',
        'IMG_GAUSSIAN',
        'IMG_GENERALIZED_CUBIC',
        'IMG_HERMITE',
        'IMG_HAMMING',
        'IMG_HANNING',
        'IMG_MITCHELL',
        'IMG_POWER',
        'IMG_QUADRATIC',
        'IMG_SINC',
        'IMG_NEAREST_NEIGHBOUR',
        'IMG_WEIGHTED4',
        'IMG_TRIANGLE',

        // json
        'JSON_ERROR_RECURSION',
        'JSON_ERROR_INF_OR_NAN',
        'JSON_ERROR_UNSUPPORTED_TYPE',

        // mysqli
        'MYSQLI_SERVER_PUBLIC_KEY',

        // 5.5.1
        'PHP_FCGI_BACKLOG',

        // 5.5.2
        'LIBXML_SCHEMA_CREATE',
    );

    public function __construct()
    {
        // normalize for processing
        $this->fooProperties = array_flip($this->fooProperties);
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
        if (isset(static::$fooProperties[$firstParameterValue])) {
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
