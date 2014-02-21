<?php

namespace Sniffs\Deprecated;

/**
 * @group RegexpEModifier
 * @group Deprecated
 *
 */
class RegexpEModifierTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.Deprecated.RegexpEModifier');
    protected $defaultType = "Php54to55.Deprecated.RegexpEModifier";

    protected $errors = array(
        '4:14',
        '7:14',
        '8:14',
        '9:14',
        // '10:17', // TODO currently not possible with phpcs: multi line string is splitted and the ending delimiter is lost
        '19:1',
        '23:1',
    );

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/regexpModifier/e.inc';
        $fixtures = parent::fixtureSniffProvider();

        return $fixtures;
    }
}
