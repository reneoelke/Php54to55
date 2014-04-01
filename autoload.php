<?php

require_once dirname(__FILE__) . '/src/autoload.php';
spl_autoload_register(array('Foobugs_Standard_Autoloader', 'autoload'));
