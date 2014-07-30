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
 * @group ReservedKeywords
 * @group PHP
 */
class ReservedKeywordsTest extends AbstractTestCase
{
    protected $sniffs = array('Php54to55.PHP.ReservedKeywords');
    protected $defaultType = "Php54to55.PHP.ReservedKeywords";

    // TODO add actually expected errors
    protected $errors = array();

    public function setUp()
    {
        $this->markTestSkipped('ReservedKeywords Sniff not yet implemented.');
    }
    /**
     * {@inheritdoc}
     */
    public function fixtureSniffProvider()
    {
        $this->fixture = __DIR__ . '/_fixtures/reservedKeywords/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        return $fixtures;
    }
}
