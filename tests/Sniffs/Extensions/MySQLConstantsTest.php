<?php

namespace Sniffs\Extensions;

/**
 * @group MySQLConstants
 * @group Extensions
 *
 */
class MySQLConstantsTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.Extensions.MySQLConstants');
    protected $defaultType = "Php54to55.Extensions.MySQLConstants";

    protected $errors = array('11:27', '14:6', '17:5', '21:1', '22:1', '23:1', '24:1', '25:1', '26:1', '27:1');

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/constants/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        return $fixtures;
    }
}
