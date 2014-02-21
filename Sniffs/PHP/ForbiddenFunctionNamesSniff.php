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

    /**
     * A list of forbidden function names
     *
     * @var array(string => array(string, [string]))
     */
    protected $forbiddenFunctions = array(
        // PHP Core
        'boolval' => null,
        'password_get_info' => null,
        'password_hash' => null,
        'password_needs_rehash' => null,
        'password_verify' => null,
        'array_column' => null,

        // curl
        'curl_escape' => null,
        'curl_multi_setopt' => null,
        'curl_multi_strerror curl_pause' => null,
        'curl_reset' => null,
        'curl_share_close' => null,
        'curl_share_init' => null,
        'curl_share_setopt curl_strerror and curl_unescape' => null,

        // Hash
        'hash_pbkdf2' => null,

        // GD
        'imageaffinematrixconcat' => null,
        'imageaffinematrixget' => null,
        'imagecrop' => null,
        'imagecropauto' => null,
        'imageflip' => null,
        'imagepalettetotruecolor' => null,
        'imagescale' => null,

        // Intl
        'datefmt_format_object' => null,
        'datefmt_get_calendar_object' => null,
        'datefmt_get_timezone' => null,
        'datefmt_set_timezone' => null,
        'datefmt_get_calendar_object' => null,
        'intlcal_create_instance' => null,
        'intlcal_get_keyword_values_for_locale' => null,
        'intlcal_get_now' => null,
        'intlcal_get_available_locales' => null,
        'intlcal_get' => null,
        'intlcal_get_time' => null,
        'intlcal_set_time' => null,
        'intlcal_add' => null,
        'intlcal_set_time_zone' => null,
        'intlcal_after' => null,
        'intlcal_before' => null,
        'intlcal_set' => null,
        'intlcal_roll' => null,
        'intlcal_clear' => null,
        'intlcal_field_difference' => null,
        'intlcal_get_actual_maximum' => null,
        'intlcal_get_actual_minimum' => null,
        'intlcal_get_day_of_week_type' => null,
        'intlcal_get_first_day_of_week' => null,
        'intlcal_get_greatest_minimum' => null,
        'intlcal_get_least_maximum' => null,
        'intlcal_get_locale' => null,
        'intlcal_get_maximum' => null,
        'intlcal_get_minimal_days_in_first_week' => null,
        'intlcal_get_minimum' => null,
        'intlcal_get_time_zone' => null,
        'intlcal_get_type' => null,
        'intlcal_get_weekend_transition' => null,
        'intlcal_in_daylight_time' => null,
        'intlcal_is_equivalent_to' => null,
        'intlcal_is_lenient' => null,
        'intlcal_is_set' => null,
        'intlcal_is_weekend' => null,
        'intlcal_set_first_day_of_week' => null,
        'intlcal_set_lenient' => null,
        'intlcal_equals' => null,
        'intlcal_get_repeated_wall_time_option' => null,
        'intlcal_get_skipped_wall_time_option' => null,
        'intlcal_set_repeated_wall_time_option' => null,
        'intlcal_set_skipped_wall_time_option' => null,
        'intlcal_from_date_time' => null,
        'intlcal_to_date_time' => null,
        'intlcal_get_error_code' => null,
        'intlcal_get_error_message' => null,
        'intlgregcal_create_instance' => null,
        'intlgregcal_set_gregorian_change' => null,
        'intlgregcal_get_gregorian_change' => null,
        'intlgregcal_is_leap_year' => null,
        'intltz_create_time_zone' => null,
        'intltz_create_default' => null,
        'intltz_get_id' => null,
        'intltz_get_gmt' => null,
        'intltz_get_unknown' => null,
        'intltz_create_enumeration' => null,
        'intltz_count_equivalent_ids' => null,
        'intltz_create_time_zone_id_enumeration' => null,
        'intltz_get_canonical_id' => null,
        'intltz_get_region' => null,
        'intltz_get_tz_data_version' => null,
        'intltz_get_equivalent_id' => null,
        'intltz_use_daylight_time' => null,
        'intltz_get_offset' => null,
        'intltz_get_raw_offset' => null,
        'intltz_has_same_rules' => null,
        'intltz_get_display_name' => null,
        'intltz_get_dst_savings' => null,
        'intltz_from_date_time_zone' => null,
        'intltz_to_date_time_zone' => null,
        'intltz_get_error_code' => null,
        'intltz_get_error_message' => null,

        // 5.5.1
        'intlcal_set_minimal_days_in_first_week' => null,

        // mysqli
        'mysqli_begin_transaction' => null,
        'mysqli_savepoint' => null,
        'mysqli_release_savepoint' => null,

        // mysqlnd
        'mysqlnd_savepoint' => null,
        'mysqlnd_release_savepoint' => null,

        // pgsql
        'pg_escape_literal' => null,
        'pg_escape_identifier' => null,

        // socket
        'socket_cmsg_space' => null,
        'socket_sendmsg' => null,
        'socket_recvmsg' => null,

        // 5.5.4
        'opcache_compile_file' => null,
    );

    /** {@inheritdoc} */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $functionName = strtolower($token['content']);

        // continue if string is a function name
        if (!array_key_exists($functionName, $this->forbiddenFunctions)) {
            return true;
        }
        // check if it’s a global method by simply checking the level
        if ($token['level'] !== 0) {
            return true;
        }
        // check if it’s a function definition
        if ($stackPtr <= 2) {
            return false;
        }
        if ($tokens[$stackPtr-2]['type'] != 'T_FUNCTION') {
            return true;
        }

        $message = sprintf(
            '%s is allready a global function defined in PHP 5.5.',
            $functionName
        );
        $phpcsFile->addError($message, $stackPtr, 'forbiddenFunctionDefintion');
    }
}
