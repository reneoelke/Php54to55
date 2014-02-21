<?php

namespace Sniffs\Deprecated;

/**
 * @group Functions
 * @group Deprecated
 *
 */
class FunctionsTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.Deprecated.Functions');
    protected $defaultType = "Php54to55.Deprecated.Functions.Deprecated";

    protected $errors = array('12:1', '15:1', '16:1', '17:1', '18:1', '19:1', '20:1', '21:1', '22:1', '23:1');

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/functions/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        // (maik) 2014-02-21 temporarily skip test case
//         $this->fixture = __DIR__ . '/_fixtures/valid.inc';
//         $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());

        return $fixtures;
    }
}
