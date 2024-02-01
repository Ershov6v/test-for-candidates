<?php

namespace App\Process\PaymentProcessor\Processor;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.payment_processor')]
interface PaymentProcessorInterface
{
    public function pay(float $price);

    public function getName(): string;
}