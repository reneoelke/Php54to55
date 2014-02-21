<?php

namespace Sniffs\PHP;

/**
 * @group ForbiddenClassNames
 * @group PHP
 *
 */
class ForbiddenClassNamesTest extends \AbstractPhpcsTestCase
{
    protected $sniffs = array('Php54to55.PHP.ForbiddenClassNames');
    protected $defaultType = "Php54to55.PHP.ForbiddenClassNames";

    protected $errors = array(
        '13:1',
        '14:1',
        '15:1', // PHP 5.4+ only
        '18:1',
        '19:1',
        '20:1',
        '21:1',
        '22:1',
        '23:1',
    );

    /** {@inheritdoc} */
    public function fixtureSniffProvider()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            // can not test traits with php 5.3
            unset($this->errors[2]);
        }

        $this->fixture = __DIR__ . '/_fixtures/forbiddenClassNames/1.inc';
        $fixtures = parent::fixtureSniffProvider();

        $this->fixture = __DIR__ . '/_fixtures/forbiddenClassNames/valid.inc';
        $fixtures[] = array($this->fixture, $this->standard, $this->sniffs, array(), array());


        return $fixtures;
    }
}
