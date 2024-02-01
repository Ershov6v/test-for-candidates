<?php

namespace App\Process\PaymentProcessor\Processor;

use App\Process\PaymentProcessor\Exception\PaymentException;
use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor as PaypalPaymentProcessorDecorate;

final class PaypalPaymentProcessor implements PaymentProcessorInterface
{
    private PaypalPaymentProcessorDecorate $processor;

    public function __construct()
    {
        $this->processor = new PaypalPaymentProcessorDecorate();
    }


    public function pay(float $price)
    {
        try {
            $this->processor->pay((int)$price);
        } catch (Exception $e) {
            throw new PaymentException($this->getName(), $e->getMessage());
        }
    }

    public function getName(): string
    {
        return 'paypal';
    }
}