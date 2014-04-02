<?php

/**
 * TODO document and test
 *
 */
class Foobugs_Standard_RunHelper
{
    protected static $skippedSniffs = array();
    protected static $phpTargetVersion;
    protected static $phpReferenceVersion;

    /**
     * Cleanup.
     */
    public static function reset()
    {
        self::$skippedSniffs = array();
        self::$phpTargetVersion = null;
        self::$phpReferenceVersion = null;
    }

    /**
     * Mark sniff skipped by class/ ref name.
     *
     * @param string $sniff
     */
    public static function markSniffSkipped($sniff)
    {
        self::$skippedSniffs[$sniff] = $sniff;
    }

    /**
     * Set PHP version to test against.
     *
     * This is the highest PHP version for which compliance should be checked.
     *
     * @return string
     */
    public static function getPhpTargetVersion()
    {
        if (!isset(self::$phpTargetVersion)) {
            // if not set try config version or fallback to current PHP version
            self::$phpTargetVersion = PHP_CodeSniffer::getConfigData('phpTargetVersion');
            if (!isset(self::$phpTargetVersion)) {
                self::$phpTargetVersion = PHP_VERSION;
            }
        }

        return self::$phpTargetVersion;
    }

    /**
     * Set PHP version to test from.
     * 
     * This is usually the version code compliance was allready tested for.
     *
     * @return string
     */
    public static function getPhpReferenceVersion()
    {
        if (!isset(self::$phpReferenceVersion)) {
            // if not set try config version or fallback to 5.0
            self::$phpReferenceVersion = PHP_CodeSniffer::getConfigData('phpReferenceVersion');
            if (!isset(self::$phpReferenceVersion)) {
                self::$phpReferenceVersion = '5.0';
            }
        }

        return self::$phpReferenceVersion;
    }
}
