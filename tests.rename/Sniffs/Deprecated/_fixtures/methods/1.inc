<?php

// valid
echo "setTimeZoneId";

echo setTimeZoneId();

MyClass::setTimeZoneId();

$setTimeZoneId();

// invalid

// assumed
$r->setTimeZoneId( $myParam );

// testable
$fmt = new IntlDateFormatter();
$fmt->setTimeZoneId($myParam);
