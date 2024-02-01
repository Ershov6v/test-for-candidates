<?php

namespace App\Lib\VATNumber;

use App\Lib\VATNumber\Exception\InvalidVATNumberException;

final class VATNumber
{
    private array $numbers = [
        '/DE[0-9]{9}/' => 0.19,
        '/IT[0-9]{11}/' => 0.22,
        '/GR[0-9]{9}/' => 0.24,
        '/FR[A-Z]{2}[0-9]{9}/' => 0.20
    ];

    private float $tax;

    public function __construct(private readonly string $number)
    {
        foreach ($this->numbers as $format => $tax) {
            if (preg_match($format, $number) !== false) {
                $this->tax = $tax;
                return;
            }
        }

        throw new InvalidVATNumberException();
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

}