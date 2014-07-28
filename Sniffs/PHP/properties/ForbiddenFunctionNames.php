<?php

return array(
    // 5.5.0
    // PHP Core
    'boolval',
    'password_get_info',
    'password_hash',
    'password_needs_rehash',
    'password_verify',
    'array_column',

    // curl
    'curl_escape',
    'curl_multi_setopt',
    'curl_multi_strerror curl_pause',
    'curl_reset',
    'curl_share_close',
    'curl_share_init',
    'curl_share_setopt curl_strerror and curl_unescape',

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

    // 5.5.4
    // Opcache
    'opcache_compile_file',
);
