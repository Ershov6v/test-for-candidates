<?php

namespace App\Lib\Coupon;

interface CouponInterface
{
    public function getType(): CouponType;

    public function getValue(): float;

    public function getName(): string;
}