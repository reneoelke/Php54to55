<?php

namespace Sniffs\PHP;

/**
 * @group ForbiddenFunctionNames
 * @group PHP
 *
 */
class ForbiddenFunctionNamesTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.PHP.ForbiddenFunctionNames');
    protected $defaultType = "Php54to55.PHP.ForbiddenFunctionNames.forbiddenFunctionDefintion";

    protected $errors = array('17:10', '19:5');

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        // TODO fails on php 5.3 (need env to debug against)
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            $this->markTestIncomplete('PHP 5.4 or newer required.');
        }
        for ($i=30; $i<118; $i++) {
            $this->errors[$i] = $i . ':10';
        }
        $this->fixture = __DIR__ . '/_fixtures/forbiddenFunctionNames/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        return $fixtures;
    }
}
