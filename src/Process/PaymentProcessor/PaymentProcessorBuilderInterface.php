<?php

namespace App\Process\PaymentProcessor;

use App\Process\PaymentProcessor\Processor\PaymentProcessorInterface;

interface PaymentProcessorBuilderInterface
{
    public function buildByName(string $name): PaymentProcessorInterface;
}