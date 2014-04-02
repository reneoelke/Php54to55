<?php

/**
 * Abstract CodeSniffer standard
 *
 */
abstract class Foobugs_Standard_AbstractSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
    );

    /**
     * Tokens listened to.
     *
     * @var array
     */
    protected $fooRegisterToken = array();

    /**
     * Configurable data set according to tested version range.
     *
     * @var array
     */
    protected $fooData = array();

    /**
     * Labels for $fooData keys.
     *
     * @var array
     */
    protected $fooLabel = array();

    /**
     * (non-PHPdoc)
     * @see PHP_CodeSniffer_Sniff::register()
     */
    public function register()
    {
        // get range from config
        $minVersion = Foobugs_Standard_RunHelper::getPhpReferenceVersion();
        $maxVersion = Foobugs_Standard_RunHelper::getPhpTargetVersion();

        // load configuration and test
        $success = Foobugs_Standard_ConfigHelper::configureSniff($this, $maxVersion, $minVersion);
        if (!$success) {
            Foobugs_Standard_RunHelper::markSniffSkipped(get_class($this));

            return array();
        }

        // TODO load configuration for range
        return $this->fooRegisterToken;
    }

    /**
     * Apply configuration from Foobugs_Standard_ConfigHelper.
     *
     * @param array $data
     */
    public function setFooData(array $data, array $label)
    {
        $this->fooData = $data;
        $this->fooLabel = $label;
    }
}
