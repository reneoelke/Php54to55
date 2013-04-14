<?php

namespace Sniffs\Generic;

/**
 * @group Methods
 * @group Deprecated
 *
 */
class MethodsTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.Deprecated.Methods');
    protected $defaultType = "Php54to55.Deprecated.Methods.Deprecated";

    protected $warnings = array('15:5', '19:7');

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/methods/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        $this->fixture = __DIR__ . '/_fixtures/valid.inc';
        $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());

        return $fixtures;
    }
}
