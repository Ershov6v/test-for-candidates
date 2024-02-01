<?php

namespace App\Process\CouponFinder;

use App\Lib\Coupon\Coupon;
use App\Lib\Coupon\CouponInterface;
use App\Lib\Coupon\CouponType;
use App\Process\CouponFinder\Exception\CouponNotFoundException;

class MemoryCouponFinder implements CouponFinderInterface
{
    private array $coupons = [];

    public function __construct()
    {
        $this->coupons['CF001'] = new Coupon('CF001', CouponType::Percent, 0.2);
        $this->coupons['CS002'] = new Coupon('CS002', CouponType::Percent, 0.6);
        $this->coupons['CT003'] = new Coupon('CT003', CouponType::Fixed, 10);
    }

    public function find(string $name): CouponInterface
    {
        if (!isset($this->coupons[$name])) {
            throw new CouponNotFoundException();
        }

        return $this->coupons[$name];
    }
}