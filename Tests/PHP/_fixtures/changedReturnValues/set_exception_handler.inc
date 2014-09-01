<?php

function exception_handler(Exception $exception) {
    return;
}

class ExceptionHandler
{
    public function handle(Exception $exception)
    {
        return;
    }
}

// valid
set_exception_handler('exception_handler');
set_exception_handler(array(new ExceptionHandler(), 'handle'));
set_exception_handler(null);
