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

use PHP_CodeSniffer_CLI;
use PHPUnit_Framework_TestCase;

/**
 * @group ForbiddenClassNames
 * @group PHP
 */
class ChangedReturnValuesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHP_CodeSniffer_CLI
     */
    protected $phpcs;

    /**
     * @var array
     */
    protected $phpcsArgs = array();

    /**
     * @var string
     */
    protected $defaultType = 'Php54to55.PHP.ChangedReturnValues';

    /**
     * @var integer
     */
    protected $defaultSeverity = 5;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->phpcs = new PHP_CodeSniffer_CLI();

        $this->phpcsArgs = $this->phpcs->getDefaults();
        $this->phpcsArgs['files'] = array();
        $this->phpcsArgs['standard'] = array(__DIR__ . '/../../ruleset.xml');
        $this->phpcsArgs['sniffs'] = array('Php54to55.PHP.ChangedReturnValues');
        $this->phpcsArgs['reports'] = array('xml' => null);
        $this->phpcsArgs['encoding'] = 'utf8';
    }

    /**
     * @param array $list
     */
    protected function fixtureExpandErrorList(array &$list)
    {
        foreach ($list as $k => &$v) {
            if (is_int($k)) {
                $list[$v] = array($this->defaultType, $this->defaultSeverity);
                unset($list[$k]);
                continue;
            }
            switch (gettype($v)) {
                case 'integer':
                case 'boolean':
                    $v = $this->defaultType;
                case 'string':
                    $v = array($v, $this->defaultSeverity);
                    break;
                case 'array':
                    if (!isset($v[1])) {
                        $v[1] = $this->defaultSeverity;
                    }
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * @param array $warnings
     */
    protected function checkPhpcsReport(array $warnings)
    {
        // get report
        ob_start();
        $this->phpcs->process($this->phpcsArgs);
        $report = ob_get_clean();

        $xml = @simplexml_load_string($report);
        // assert that a report was generated
        $this->assertNotEmpty($xml, 'Could not verify phpcs xml report.');

        // test warnings
        $reported = array();
        $this->fixtureExpandErrorList($warnings);
        foreach ($xml->xpath('//warning') as $element) {
            $id = ((int) $element['line']) . ':' . ((int) $element['column']);
            $reported[$id] = array((string) $element['source'], (int) $element['severity']);
        }
        $this->assertEquals($warnings, $reported, 'Mismatch between expected and reported warnings.');
    }

    /**
     * Test warnings for using function set_error_handler().
     */
    public function testSetErrorHandler()
    {
        // set phpcs arguments
        $this->phpcsArgs['files'] = array(__DIR__ . '/_fixtures/changedReturnValues/set_error_handler.inc');

        $warnings = array(
            '16:1',
            '17:1',
            '18:1'
        );
        $this->checkPhpcsReport($warnings);
    }

    /**
     * Test warnings for using function set_exception_handler().
     */
    public function testSetExceptionHandler()
    {
        // set phpcs arguments
        $this->phpcsArgs['files'] = array(__DIR__ . '/_fixtures/changedReturnValues/set_exception_handler.inc');

        $warnings = array(
            '16:1',
            '17:1',
            '18:1'
        );
        $this->checkPhpcsReport($warnings);
    }
}
