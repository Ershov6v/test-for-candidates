<?php

namespace App\Process\CouponFinder;

use App\Lib\Coupon\CouponInterface;

interface CouponFinderInterface
{
    public function find(string $name): CouponInterface;
}