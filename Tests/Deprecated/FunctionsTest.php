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
 * @group Functions
 * @group Deprecated
 */
class FunctionsTest extends AbstractTestCase
{
    protected $sniffs = array('Php54to55.Deprecated.Functions');
    protected $defaultType = "Php54to55.Deprecated.Functions.Deprecated";

    protected $errors = array('12:1', '15:1', '16:1', '17:1', '18:1', '19:1', '20:1', '21:1', '22:1', '23:1');

    /**
     * {@inheritdoc}
     */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/functions/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        // (maik) 2014-02-21 temporarily skip test case
//         $this->fixture = __DIR__ . '/_fixtures/valid.inc';
//         $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());

        return $fixtures;
    }

    public function testValidFixture()
    {
        $this->markTestSkipped('PHP_Codesniffer is overly restrict with forbidden functions.');
    }
}
