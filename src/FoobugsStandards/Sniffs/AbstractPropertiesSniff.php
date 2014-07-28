<?php

namespace FoobugsStandards\Sniffs;

use PHP_CodeSniffer_Sniff;

abstract class AbstractPropertiesSniff extends AbstractSniff
{
    protected static $fooProperties;

    /**
     * (non-PHPdoc)
     * @see \FoobugsStandards\Sniffs\AbstractSniff::register()
     */
    public function register()
    {
        if (!isset(static::$fooProperties)) {
            // load properties from file
            // TODO use some wrapper/ factory!
            // -TODO make testable and do test
            $class = get_class($this);
            $class = substr($class, strpos($class, '\\Sniffs') + 7, -5);
            $prefix = explode('\\', $class);
            $shortName = array_pop($prefix);
            $prefix = implode('/', $prefix);
            $fn = realpath(__DIR__ . '/../../../Sniffs') . $prefix . '/properties/' . $shortName . '.php';

            $properties = require $fn;

            static::$fooProperties = array_flip($properties);
        }

        return parent::register();
    }
}
