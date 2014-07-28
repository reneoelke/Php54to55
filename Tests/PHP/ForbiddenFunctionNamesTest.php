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
 * @group ForbiddenFunctionNames
 * @group PHP
 */
class ForbiddenFunctionNamesTest extends AbstractTestCase
{
    protected $sniffs = array('Php54to55.PHP.ForbiddenFunctionNames');
    protected $defaultType = "Php54to55.PHP.ForbiddenFunctionNames.forbiddenFunctionDefintion";

    protected $errors = array('17:10', '19:5');

    /**
     * {@inheritdoc}
     */
    public function fixtureSniffProvider()
    {
        for ($i = 30; $i < 118; $i++) {
            $this->errors[$i] = $i . ':10';
        }
        $this->fixture = __DIR__ . '/_fixtures/forbiddenFunctionNames/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        return $fixtures;
    }
}
