<?php

namespace App\Process\PaymentProcessor\Exception;

use Exception;

class PaymentProcessorNotFoundException extends Exception
{
    protected $message = 'Payment processor not found';
}