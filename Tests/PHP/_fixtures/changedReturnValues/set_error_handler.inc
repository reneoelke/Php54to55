<?php

function error_handler($errno, $errstr, $errfile = '', $errline = 0, $errcontext = array()) {
    return true;
}

class ErrorHandler
{
    public function handle($errno, $errstr, $errfile = '', $errline = 0, $errcontext = array())
    {
        return true;
    }
}

// valid
set_error_handler('error_handler');
set_error_handler(array(new ErrorHandler(), 'handle'));
set_error_handler(null);
