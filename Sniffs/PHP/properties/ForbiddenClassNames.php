<?php

$properties = array(
    // PHP 5.5.0
    // intl
    'IntlCalendar',
    'IntlGregorianCalendar',
    'IntlTimeZone',
    'IntlBreakIterator',
    'IntlRuleBasedBreakIterator',
    'IntlCodePointBreakIterator',

    // DateTime
    'DateTimeImmutable',

    // curl
    'CURLFile',
);

// normalise
foreach ($properties as $k => $v) {
    unset($properties[$k]);
    $properties[$v] = strtolower($v);
}

return $properties;
