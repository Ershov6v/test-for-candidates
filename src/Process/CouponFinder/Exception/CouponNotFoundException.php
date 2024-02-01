<?php

namespace App\Process\CouponFinder\Exception;

use Exception;

class CouponNotFoundException extends Exception
{
    protected $message = 'Coupon not found';
}