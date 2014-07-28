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
 * @group Methods
 * @group Deprecated
 */
class MethodsTest extends AbstractTestCase
{
    protected $sniffs = array('Php54to55.Deprecated.Methods');
    protected $defaultType = "Php54to55.Deprecated.Methods.Deprecated";

    protected $warnings = array('15:5', '19:7');

    /**
     * {@inheritdoc}
     */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/methods/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        $this->fixture = __DIR__ . '/_fixtures/valid.inc';
        $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());

        return $fixtures;
    }
}
