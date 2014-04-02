<?php

/**
 * Static helper to load and process sniff configuration
 * according to reference and target PHP versions.
 *
 * Config files expected under self::$path (setConfigPath() method).
 * Config files must be named exactly like the class name of the corresponding sniff.
 */
class Foobugs_Standard_ConfigHelper
{
    /**
     * Path to sniff configuration files.
     *
     * @var string
     */
    protected static $path;

    /**
     * Set path to sniff config files.
     *
     * @param string $path
     */
    public static function setConfigPath($path)
    {
        self::$path = $path;
    }

    /**
     * Provide sniff configuration (especially on `Sniff::register()`).
     *
     * @param Foobugs_Standard_AbstractSniff $sniff
     * @param string $targetVersion
     * @param string $referenceVersion
     *
     * @return null if no configuration exists
     * @return boolean success status if configuration exists
     */
    public static function configureSniff(
        Foobugs_Standard_AbstractSniff $sniff,
        $targetVersion = null,
        $referenceVersion = null
    ) {
        // TODO cleanup variable names and coding
        $fn = self::$path . get_class($sniff) . '.php';

        if (!file_exists($fn)) {
            // no config
            return ;
        }

        // try to load configuration
        $configByVersion = include $fn;
        if (!$configByVersion || !is_array($configByVersion)) {
            // -TODO error condition: config invalid are file not readable
            return false;
        }

        // append configuration segments by version starting from newest
        $configToUse = array();
        $configLabels = array();
        krsort($configByVersion);
        foreach ($configByVersion as $sinceVersion => $config) {
            if (isset($referenceVersion) && version_compare($sinceVersion, $referenceVersion, '<')) {
                // config segment lower than min. required version
                continue;
            }
            if (isset($targetVersion) && version_compare($sinceVersion, $targetVersion, '>')) {
                // config segment greater than max. required version
                continue;
            }
            // set version references for verbose reporting
            foreach ($config as $k => $v) {
                $configLabels[$k] = $sinceVersion;
            }
            // append segment
            // ordering implies that higher version segment will override
            $configToUse += $config;
        }

        // test
        if ($configToUse === array()) {
            // empty
            return false;
        }

        // apply configuration
        $sniff->setFooData($configToUse, $configLabels);

        return true;
    }
}
