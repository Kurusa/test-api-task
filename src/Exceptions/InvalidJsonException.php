<?php

namespace App\Exceptions;

use Exception;

class InvalidJsonException extends Exception
{
    protected $message = 'Invalid JSON';
    protected $code = 400;
}
