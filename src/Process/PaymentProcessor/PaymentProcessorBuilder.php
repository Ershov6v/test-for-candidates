<?php

namespace App\Process\PaymentProcessor;

use App\Process\PaymentProcessor\Exception\PaymentProcessorNotFoundException;
use App\Process\PaymentProcessor\Processor\PaymentProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class PaymentProcessorBuilder implements PaymentProcessorBuilderInterface
{
    public function __construct(#[TaggedIterator('app.payment_processor')]
                                private iterable $processors)
    {
    }

    public function buildByName(string $name): PaymentProcessorInterface
    {
        /**
         * @var PaymentProcessorInterface $processor
         */
        foreach ($this->processors as $processor) {
            if ($name == $processor->getName()) {
                return $processor;
            }
        }

        throw new PaymentProcessorNotFoundException();
    }
}