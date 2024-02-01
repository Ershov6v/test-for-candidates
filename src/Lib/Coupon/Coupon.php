<?php

namespace App\Lib\Coupon;

class Coupon implements CouponInterface
{
    public function __construct(private string $name, private CouponType $type, private float $value)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): CouponType
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }

}