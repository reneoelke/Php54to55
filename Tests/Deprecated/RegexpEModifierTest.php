<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Tests\Deprecated;

use Php54to55\Tests\AbstractTestCase;

/**
 * @group RegexpEModifier
 * @group Deprecated
 */
class RegexpEModifierTest extends AbstractTestCase
{
    protected $sniffs = array('Php54to55.Deprecated.RegexpEModifier');
    protected $defaultType = "Php54to55.Deprecated.RegexpEModifier";

    protected $warnings = array(
        '4:14',
        '7:14',
        '8:14',
        '9:14',
        // '10:17', // TODO currently not possible with phpcs: multi line string is splitted and the ending delimiter is lost
        '19:1',
        '23:1',
    );

    /**
     * {@inheritdoc}
     */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/regexpModifier/e.inc';
        $fixtures = parent::fixtureSniffProvider();

        return $fixtures;
    }
}
