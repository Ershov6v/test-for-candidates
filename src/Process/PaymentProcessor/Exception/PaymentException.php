<?php

namespace App\Process\PaymentProcessor\Exception;

use Exception;
use Throwable;

class PaymentException extends Exception
{
    public function __construct(string $processorName, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Processor: ' . $processorName . ' Error: ' . $message, $code, $previous);
    }
}