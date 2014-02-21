<?php

namespace Sniffs\Extensions;

/**
 * @group MySQLFunctions
 * @group Extensions
 *
 */
class MySQLFunctionsTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.Extensions.MySQLFunctions');
    protected $defaultType = "Php54to55.Extensions.MySQLFunctions.Deprecated";

    protected $errors = array('13:1');

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        for ($i=16; $i<64; $i++) {
            $this->errors[$i] = $i . ':1';
        }
        $this->fixture = __DIR__ . '/_fixtures/functions/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        // (maik) 2014-02-21 temporarily skip test case
//         $this->fixture = __DIR__ . '/_fixtures/valid.inc';
//         $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());

        return $fixtures;
    }
}
