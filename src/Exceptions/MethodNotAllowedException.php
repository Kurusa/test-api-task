<?php

namespace App\Exceptions;

use Exception;

class MethodNotAllowedException extends Exception
{
    protected $message = 'Method Not Allowed';
    protected $code = 405;
}
