<?php

// valid
echo "IntlCalendar";

use Vendor\IntlCalendar as IntlCalendar;

function IntlCalendar() {}
IntlCalendar::method();
new IntlCalendar();

// invalid
class /* comment */ intlcalendar {}
interface IntlCalendar {}
trait IntlCalendar {}

// checklist
class IntlCalendar{}
class IntlGregorianCalendar{}
class IntlTimeZone{}
class IntlBreakIterator{}
class IntlRuleBasedBreakIterator{}
class IntlCodePointBreakIterator{}
