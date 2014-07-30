<?php

class finally {}
trait finally {}
interface finally {}
function finally() {};
$finally = 'finally';
$x = <<<EOD
finally
EOD;
$x = <<<finally
valid
finally;

try {
    // fail
} catch (Exception $e) {
    // report
} finally {
    // cleanup
}

use finally;
namespace This\is\finally\invalid;

x instanceof finally;
