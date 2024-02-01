<?php

namespace App\Lib\Coupon;

enum CouponType: int
{
    case Percent = 1;

    case Fixed = 2;
}