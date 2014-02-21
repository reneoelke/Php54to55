<?php

/**
 * Forbidden Function Names
 *
 * Searches for global definitions of functions which have been added in
 * PHP 5.5 and would lead to conflicts.
 *
 * A complete list: http://www.php.net/manual/en/migration55.new-functions.php
 *
 * @author    Marcel Eichner // foobugs <marcel.eichner@foobugs.com>
 * @author    Maik Penz // foobugs <maik.penz@foobugs.com>
 * @copyright 2012,2014 foobugs oelke & eichner GbR
 * @license   BSD http://www.opensource.org/licenses/bsd-license.php
 * @link      https://github.com/foobugs/PHP54to55
 */
class Php54to55_Sniffs_PHP_ForbiddenFunctionNamesSniff implements PHP_CodeSniffer_Sniff
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
            T_STRING,
        );
    }

    protected $functionNameIgnore = array(
        T_WHITESPACE => true,
        T_COMMENT => true,
    );

    /**
     * A list of forbidden function names
     *
     * @var array(string => array(string, [string]))
     */
    protected $forbiddenFunctions = array(
        // PHP Core
        'boolval' => true,
        'password_get_info' => true,
        'password_hash' => true,
        'password_needs_rehash' => true,
        'password_verify' => true,
        'array_column' => true,

        // curl
        'curl_escape' => true,
        'curl_multi_setopt' => true,
        'curl_multi_strerror curl_pause' => true,
        'curl_reset' => true,
        'curl_share_close' => true,
        'curl_share_init' => true,
        'curl_share_setopt curl_strerror and curl_unescape' => true,

        // Hash
        'hash_pbkdf2' => true,

        // GD
        'imageaffinematrixconcat' => true,
        'imageaffinematrixget' => true,
        'imagecrop' => true,
        'imagecropauto' => true,
        'imageflip' => true,
        'imagepalettetotruecolor' => true,
        'imagescale' => true,

        // Intl
        'datefmt_format_object' => true,
        'datefmt_get_calendar_object' => true,
        'datefmt_get_timezone' => true,
        'datefmt_set_timezone' => true,
        'datefmt_get_calendar_object' => true,
        'intlcal_create_instance' => true,
        'intlcal_get_keyword_values_for_locale' => true,
        'intlcal_get_now' => true,
        'intlcal_get_available_locales' => true,
        'intlcal_get' => true,
        'intlcal_get_time' => true,
        'intlcal_set_time' => true,
        'intlcal_add' => true,
        'intlcal_set_time_zone' => true,
        'intlcal_after' => true,
        'intlcal_before' => true,
        'intlcal_set' => true,
        'intlcal_roll' => true,
        'intlcal_clear' => true,
        'intlcal_field_difference' => true,
        'intlcal_get_actual_maximum' => true,
        'intlcal_get_actual_minimum' => true,
        'intlcal_get_day_of_week_type' => true,
        'intlcal_get_first_day_of_week' => true,
        'intlcal_get_greatest_minimum' => true,
        'intlcal_get_least_maximum' => true,
        'intlcal_get_locale' => true,
        'intlcal_get_maximum' => true,
        'intlcal_get_minimal_days_in_first_week' => true,
        'intlcal_get_minimum' => true,
        'intlcal_get_time_zone' => true,
        'intlcal_get_type' => true,
        'intlcal_get_weekend_transition' => true,
        'intlcal_in_daylight_time' => true,
        'intlcal_is_equivalent_to' => true,
        'intlcal_is_lenient' => true,
        'intlcal_is_set' => true,
        'intlcal_is_weekend' => true,
        'intlcal_set_first_day_of_week' => true,
        'intlcal_set_lenient' => true,
        'intlcal_equals' => true,
        'intlcal_get_repeated_wall_time_option' => true,
        'intlcal_get_skipped_wall_time_option' => true,
        'intlcal_set_repeated_wall_time_option' => true,
        'intlcal_set_skipped_wall_time_option' => true,
        'intlcal_from_date_time' => true,
        'intlcal_to_date_time' => true,
        'intlcal_get_error_code' => true,
        'intlcal_get_error_message' => true,
        'intlgregcal_create_instance' => true,
        'intlgregcal_set_gregorian_change' => true,
        'intlgregcal_get_gregorian_change' => true,
        'intlgregcal_is_leap_year' => true,
        'intltz_create_time_zone' => true,
        'intltz_create_default' => true,
        'intltz_get_id' => true,
        'intltz_get_gmt' => true,
        'intltz_get_unknown' => true,
        'intltz_create_enumeration' => true,
        'intltz_count_equivalent_ids' => true,
        'intltz_create_time_zone_id_enumeration' => true,
        'intltz_get_canonical_id' => true,
        'intltz_get_region' => true,
        'intltz_get_tz_data_version' => true,
        'intltz_get_equivalent_id' => true,
        'intltz_use_daylight_time' => true,
        'intltz_get_offset' => true,
        'intltz_get_raw_offset' => true,
        'intltz_has_same_rules' => true,
        'intltz_get_display_name' => true,
        'intltz_get_dst_savings' => true,
        'intltz_from_date_time_zone' => true,
        'intltz_to_date_time_zone' => true,
        'intltz_get_error_code' => true,
        'intltz_get_error_message' => true,

        // 5.5.1
        'intlcal_set_minimal_days_in_first_week' => true,

        // mysqli
        'mysqli_begin_transaction' => true,
        'mysqli_savepoint' => true,
        'mysqli_release_savepoint' => true,

        // mysqlnd
        'mysqlnd_savepoint' => true,
        'mysqlnd_release_savepoint' => true,

        // pgsql
        'pg_escape_literal' => true,
        'pg_escape_identifier' => true,

        // socket
        'socket_cmsg_space' => true,
        'socket_sendmsg' => true,
        'socket_recvmsg' => true,

        // 5.5.4
        'opcache_compile_file' => true,
    );

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $functionName = strtolower($token['content']);

        // continue if string is a function name
        if (!isset($this->forbiddenFunctions[$functionName])) {
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
            '%s is allready a global function defined in PHP 5.5.',
            $functionName
        );
        $phpcsFile->addError($message, $stackPtr, 'forbiddenFunctionDefintion');
    }
}
