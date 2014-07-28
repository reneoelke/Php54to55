<?php

$levelUp = strstr(__DIR__, '/vendor') ? '/../../../..' : '/..';
$rootPath = realpath(__DIR__ . $levelUp);

if (is_file($rootPath . '/vendor/autoload.php')) {
    require $rootPath . '/vendor/autoload.php';
}
