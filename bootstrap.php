<?php

// try composer autoloading
$autoloaders = array(
    dirname(__FILE__) . '/vendor/autoload.php', // standalone
    dirname(__FILE__) . '/../../autoload.php', // directly through composer
    dirname(__FILE__) . '/../../../../../autoload.php', // as phpcs standard through composer
    dirname(__FILE__) . '/autoload.php', // fallback
);
foreach ($autoloaders as $autoloaderPath) {
    if (file_exists($autoloaderPath)) {
        require_once $autoloaderPath;
        break;
    }
}
if (!class_exists('Foobugs_Standard_AbstractStandard', true)) {
    // TODO die properly
}
unset($autoloaders);

// prepare for run
Foobugs_Standard_RunHelper::reset();
Foobugs_Standard_ConfigHelper::setConfigPath(dirname(__FILE__) . '/config/');
