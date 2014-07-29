<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Tests\PHP;

use Php54to55\Tests\AbstractTestCase;

/**
 * @group ForbiddenConstantNames
 * @group PHP
 */
class ForbiddenConstantNamesTest extends AbstractTestCase
{
    protected $sniffs = array('Php54to55.PHP.ForbiddenConstantNames');
    protected $defaultType = "Php54to55.PHP.ForbiddenConstantNames.invalidConstantName";

    protected $errors = array(
        '3:8',
        '7:1',
    );

    /**
     * {@inheritdoc}
     */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/forbiddenConstantNames/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        $this->fixture = __DIR__ . '/_fixtures/forbiddenConstantNames/valid.inc';
        $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());

        return $fixtures;
    }
}
