<?php

namespace App\Process\PaymentProcessor\Processor;

use App\Process\PaymentProcessor\Exception\PaymentException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor as StripePaymentProcessorDecorate;

final class StripePaymentProcessor implements PaymentProcessorInterface
{
    private StripePaymentProcessorDecorate $processor;

    public function __construct()
    {
        $this->processor = new StripePaymentProcessorDecorate();
    }

    public function pay(float $price)
    {
        if (!$this->processor->processPayment($price)) {
            throw new PaymentException($this->getName(), 'Payment error');
        }
    }

    public function getName(): string
    {
        return 'stripe';
    }
}