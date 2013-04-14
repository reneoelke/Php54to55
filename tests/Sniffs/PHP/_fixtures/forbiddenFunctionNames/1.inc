<?php

// valid
class boolval {
    function boolval() {}
    static function boolval() {}
    public function boolval() {}
}
interface boolval {}
trait boolval {}
$boolval = function() {};
MyClass::boolval();
boolval('123');
boolval();

// invalid
function boolval /* comment */ () {}
function /* comment */
    BoOlVaL
    # 123
// foo
( $bar ) {
    // body
    $is = 1 + 2 - 3 == 0 * boolval();

    return true === $is;
}

// checklist
function boolval() {}                                                // PHP Core
function password_get_info() {}
function password_hash() {}
function password_needs_rehash() {}
function password_verify() {}
function hash_pbkdf2() {}                                                // Hash
function imageaffinematrixconcat() {}                                      // GD
function imageaffinematrixget() {}
function imagecrop() {}
function imagecropauto() {}
function imageflip() {}
function imagepalettetotruecolor() {}
function imagescale() {}
function datefmt_format_object() {}                                      // Intl
function datefmt_get_calendar_object() {}
function datefmt_get_timezone() {}
function datefmt_set_timezone() {}
function datefmt_get_calendar_object() {}
function intlcal_create_instance() {}
function intlcal_get_keyword_values_for_locale() {}
function intlcal_get_now() {}
function intlcal_get_available_locales() {}
function intlcal_get() {}
function intlcal_get_time() {}
function intlcal_set_time() {}
function intlcal_add() {}
function intlcal_set_time_zone() {}
function intlcal_after() {}
function intlcal_before() {}
function intlcal_set() {}
function intlcal_roll() {}
function intlcal_clear() {}
function intlcal_field_difference() {}
function intlcal_get_actual_maximum() {}
function intlcal_get_actual_minimum() {}
function intlcal_get_day_of_week_type() {}
function intlcal_get_first_day_of_week() {}
function intlcal_get_greatest_minimum() {}
function intlcal_get_least_maximum() {}
function intlcal_get_locale() {}
function intlcal_get_maximum() {}
function intlcal_get_minimal_days_in_first_week() {}
function intlcal_get_minimum() {}
function intlcal_get_time_zone() {}
function intlcal_get_type() {}
function intlcal_get_weekend_transition() {}
function intlcal_in_daylight_time() {}
function intlcal_is_equivalent_to() {}
function intlcal_is_lenient() {}
function intlcal_is_set() {}
function intlcal_is_weekend() {}
function intlcal_set_first_day_of_week() {}
function intlcal_set_lenient() {}
function intlcal_equals() {}
function intlcal_get_repeated_wall_time_option() {}
function intlcal_get_skipped_wall_time_option() {}
function intlcal_set_repeated_wall_time_option() {}
function intlcal_set_skipped_wall_time_option() {}
function intlcal_from_date_time() {}
function intlcal_to_date_time() {}
function intlcal_get_error_code() {}
function intlcal_get_error_message() {}
function intlgregcal_create_instance() {}
function intlgregcal_set_gregorian_change() {}
function intlgregcal_get_gregorian_change() {}
function intlgregcal_is_leap_year() {}
function intltz_create_time_zone() {}
function intltz_create_default() {}
function intltz_get_id() {}
function intltz_get_gmt() {}
function intltz_get_unknown() {}
function intltz_create_enumeration() {}
function intltz_count_equivalent_ids() {}
function intltz_create_time_zone_id_enumeration() {}
function intltz_get_canonical_id() {}
function intltz_get_region() {}
function intltz_get_tz_data_version() {}
function intltz_get_equivalent_id() {}
function intltz_use_daylight_time() {}
function intltz_get_offset() {}
function intltz_get_raw_offset() {}
function intltz_has_same_rules() {}
function intltz_get_display_name() {}
function intltz_get_dst_savings() {}
function intltz_from_date_time_zone() {}
function intltz_to_date_time_zone() {}
function intltz_get_error_code() {}
function intltz_get_error_message() {}
