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
use Php54to55\Sniffs\SniffBase;

/**
 * Forbidden Function Names
 *
 * Searches for global definitions of functions which have been added in
 * PHP 5.5 and would lead to conflicts.
 *
 * A complete list: http://www.php.net/manual/en/migration55.new-functions.php
 *
 * @package Php54to55
 * @author René Oelke <rene.oelke@foobugs.com>
 * @author Marcel Eichner <marcel.eichner@foobugs.com>
 * @author Maik Penz <maik.penz@foobugs.com>
 * @copyright 2013-2014 foobugs Oelke & Eichner GbR <mail@foobugs.com>
 * @license The MIT License (http://www.opensource.org/licenses/MIT)
 * @link Php54to55 (https://github.com/foobugs-standards/php54to55)
 */
class ForbiddenFunctionNamesSniff extends SniffBase
{
    /**
     * @var array
     */
    protected $functionNameIgnore = array(
        T_WHITESPACE => true,
        T_COMMENT => true,
    );

    protected $fooRegisterTokens = array(
        T_STRING,
    );

    protected $fooProperties = array(
        // 5.5.0
        // PHP Core
        'boolval',
        'array_column',
        'password_get_info',
        'password_hash',
        'password_needs_rehash',
        'password_verify',

        // curl
        'curl_escape',
        'curl_multi_setopt',
        'curl_multi_strerror',
        'curl_pause',
        'curl_reset',
        'curl_share_close',
        'curl_share_init',
        'curl_share_setopt',
        'curl_strerror',
        'curl_unescape',

        // Hash
        'hash_pbkdf2',

        // GD
        'imageaffinematrixconcat',
        'imageaffinematrixget',
        'imagecrop',
        'imagecropauto',
        'imageflip',
        'imagepalettetotruecolor',
        'imagescale',

        // Intl
        'datefmt_format_object',
        'datefmt_get_calendar_object',
        'datefmt_get_timezone',
        'datefmt_set_timezone',
        'intlcal_create_instance',
        'intlcal_get_keyword_values_for_locale',
        'intlcal_get_now',
        'intlcal_get_available_locales',
        'intlcal_get',
        'intlcal_get_time',
        'intlcal_set_time',
        'intlcal_add',
        'intlcal_set_time_zone',
        'intlcal_after',
        'intlcal_before',
        'intlcal_set',
        'intlcal_roll',
        'intlcal_clear',
        'intlcal_field_difference',
        'intlcal_get_actual_maximum',
        'intlcal_get_actual_minimum',
        'intlcal_get_day_of_week_type',
        'intlcal_get_first_day_of_week',
        'intlcal_get_greatest_minimum',
        'intlcal_get_least_maximum',
        'intlcal_get_locale',
        'intlcal_get_maximum',
        'intlcal_get_minimal_days_in_first_week',
        'intlcal_get_minimum',
        'intlcal_get_time_zone',
        'intlcal_get_type',
        'intlcal_get_weekend_transition',
        'intlcal_in_daylight_time',
        'intlcal_is_equivalent_to',
        'intlcal_is_lenient',
        'intlcal_is_set',
        'intlcal_is_weekend',
        'intlcal_set_first_day_of_week',
        'intlcal_set_lenient',
        'intlcal_equals',
        'intlcal_get_repeated_wall_time_option',
        'intlcal_get_skipped_wall_time_option',
        'intlcal_set_repeated_wall_time_option',
        'intlcal_set_skipped_wall_time_option',
        'intlcal_from_date_time',
        'intlcal_to_date_time',
        'intlcal_get_error_code',
        'intlcal_get_error_message',
        'intlgregcal_create_instance',
        'intlgregcal_set_gregorian_change',
        'intlgregcal_get_gregorian_change',
        'intlgregcal_is_leap_year',
        'intltz_create_time_zone',
        'intltz_create_default',
        'intltz_get_id',
        'intltz_get_gmt',
        'intltz_get_unknown',
        'intltz_create_enumeration',
        'intltz_count_equivalent_ids',
        'intltz_create_time_zone_id_enumeration',
        'intltz_get_canonical_id',
        'intltz_get_region',
        'intltz_get_tz_data_version',
        'intltz_get_equivalent_id',
        'intltz_use_daylight_time',
        'intltz_get_offset',
        'intltz_get_raw_offset',
        'intltz_has_same_rules',
        'intltz_get_display_name',
        'intltz_get_dst_savings',
        'intltz_from_date_time_zone',
        'intltz_to_date_time_zone',
        'intltz_get_error_code',
        'intltz_get_error_message',

        // 5.5.1
        // Intl
        'intlcal_set_minimal_days_in_first_week',

        // mysqli
        'mysqli_begin_transaction',
        'mysqli_savepoint',
        'mysqli_release_savepoint',

        // mysqlnd
        'mysqlnd_savepoint',
        'mysqlnd_release_savepoint',

        // pgsql
        'pg_escape_literal',
        'pg_escape_identifier',

        // socket
        'socket_cmsg_space',
        'socket_sendmsg',
        'socket_recvmsg',

        // 5.5.5
        // Opcache
        'opcache_compile_file',

        // 5.5.10
        // LDAP
        'ldap_modify_batch',

        // 5.5.11
        // Opcache
        'opcache_is_script_cached',
    );

    public function __construct()
    {
        // normalize for processing
        $this->fooProperties = array_flip($this->fooProperties);
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $functionName = strtolower($token['content']);

        // continue if string is a function name
        if (!isset($this->fooProperties[$functionName])) {
            return true;
        }

        // check if it’s a global method by simply checking the level
        if ($token['level'] !== 0) {
            return true;
        }

        // check if it is a function definition
        if ($stackPtr <= 2) {
            return false;
        }

        // there may be some tokens between T_FUNCTION and function name: skip those
        $stackPtrIterator = $stackPtr-2;
        while ($stackPtrIterator > 1 && isset($this->functionNameIgnore[$tokens[$stackPtrIterator]['code']])) {
            $stackPtrIterator--;
        }
        if ($tokens[$stackPtrIterator]['type'] != 'T_FUNCTION') {
            return true;
        }

        $message = sprintf(
            '%s is allready a global function defined in PHP 5.5',
            $functionName
        );
        $phpcsFile->addError($message, $stackPtr, 'forbiddenFunctionDefintion');
    }
}
