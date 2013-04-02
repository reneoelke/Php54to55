<?php

/**
 * Tests phpcs output on fixtures against expected reports.
 *
 */
class AbstractPhpcsTest
{
    /** @var string */
    public static $phpcsBinary;

    /** @var boolean */
    public static $useStandardPath = false;

    /**
     * Get the name of the standard to test against.
     *
     * @return string
     */
    abstract public function getStandardName();

    /** 
     * Get the name(s) of the sniff(s) to test against.
     *
     * @return array
     */
    abstract public function getSniffNames();

    /**
     * Gives a list of [FIXTURE_NAME].
     *
     * For each fixture a file './_fixtures/FIXTURE_NAME.php' is tested against
     * the phpcs binary with the standard getStandardName() and sniffs from
     * getSniffNames().
     * The report is matched against './_fixtures/FIXTURE_NAME.xml'.
     *
     * @return array
     */
    abstract function fixtureSniffTestProvider();

    public function setUp()
    {
        // TODO on empty binary path skip
    }

    /**
     * @dataProvider fixtureSniffTestProvider
     */
    public function fixtureSniffTest($fixtureName)
    {
        // TODO implement report generation
        // TODO implement report parser
        // TODO implement validation
    }
}
