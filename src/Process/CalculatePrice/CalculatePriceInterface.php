<?php

namespace App\Process\CalculatePrice;

use App\Lib\Coupon\CouponInterface;
use App\Lib\Product\ProductInterface;
use App\Lib\VATNumber\VATNumber;

interface CalculatePriceInterface
{
    public function calculate(ProductInterface $product, VATNumber $VATNumber, ?CouponInterface $coupon = null): float;
}