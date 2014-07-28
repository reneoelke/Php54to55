<?php

/*
 * This file is part of the Php54to55 package.
 *
 * Copyright (c) 2013-2014, foobugs Oelke & Eichner GbR <mail@foobugs.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Php54to55\Tests;

use PHPUnit_Framework_TestCase;

/**
 * Compares phpcs report on fixtures against expected report.
 *
 */
abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $standard = 'Php54to55';

    /**
     * @var string
     */
    protected $fixture;

    /**
     * @var string
     */
    protected $defaultType;

    /**
     * @var array
     */
    protected $sniffs = array();

    /**
     * @var array
     */
    protected $warnings = array();

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var integer
     */
    protected $defaultSeverity = 5;

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
     * For each fixture a file './_fixtures/FIXTURE_NAME.php' is tested against
     * the phpcs binary with getStandardName() and sniffs from getSniffNames().
     * The report is matched against the second value.
     *
     * @return array
     */
    public function fixtureSniffProvider()
    {
        $fixtures = array();
        if ($this->fixture) {
            $fixtures[] = array(
                $this->fixture,
                $this->standard,
                $this->sniffs,
                $this->errors,
                $this->warnings,
            );
        }

        return $fixtures;
    }

    /**
     * @dataProvider fixtureSniffProvider
     *
     * @param string $fixture  path to fixture
     * @param string $standard phpcs standard name -TODO remove unused argument
     * @param array  $sniffs   sniff names, or empty for all sniffs
     * @param array  $errors   expected errors
     * @param array  $warnings expected warnings
     */
    public function testFixtureSniff($fixture, $standard, $sniffs, $errors, $warnings)
    {
        // -TODO may dig deeper into phpcs to circumvent reporting and standard validation/ cli overhead
        $phpcs = new \PHP_CodeSniffer_CLI();

        // set phpcs arguments
        $args = $phpcs->getDefaults();
        $args['files'] = array($fixture);
        $args['standard'] = array(dirname(__DIR__) . '/ruleset.xml');
        $args['sniffs'] = $sniffs;
        $args['reports'] = array('xml' => null);
        $args['encoding'] = 'utf8';

        // get report
        ob_start();
        $phpcs->process($args);
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

        // test errors
        $reported = array();
        $this->fixtureExpandErrorList($errors);
        foreach ($xml->xpath('//error') as $element) {
            $id = ((int) $element['line']) . ':' . ((int) $element['column']);
            $reported[$id] = array((string) $element['source'], (int) $element['severity']);
        }
        $this->assertEquals($errors, $reported, 'Mismatch between expected and reported errors.');
    }
}
