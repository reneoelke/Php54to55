<?php

use Php54to55\Tests\AbstractTestCase;

require __DIR__ . '/../Sniffs/bootstrap.php';
require __DIR__ . '/AbstractTestCase.php';

// set binary for integration tests
AbstractTestCase::$phpcsBinary = dirname(__DIR__) . '/bin/snout';
