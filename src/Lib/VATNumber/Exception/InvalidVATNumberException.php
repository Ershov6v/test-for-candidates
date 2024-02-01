<?php

namespace App\Lib\VATNumber\Exception;

use Exception;

class InvalidVATNumberException extends Exception
{
    protected $message = 'Invalid VATNumber';
}