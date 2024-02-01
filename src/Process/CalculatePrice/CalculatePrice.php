<?php

namespace App\Process\CalculatePrice;

use App\Lib\Coupon\CouponInterface;
use App\Lib\Coupon\CouponType;
use App\Lib\Product\ProductInterface;
use App\Lib\VATNumber\VATNumber;

class CalculatePrice implements CalculatePriceInterface
{
    public function calculate(ProductInterface $product, VATNumber $VATNumber, ?CouponInterface $coupon = null): float
    {
        $price = $product->getPrice();

        if ($coupon) {
            $price = match ($coupon->getType()) {
                CouponType::Percent => $price - ($price * $coupon->getValue()),
                CouponType::Fixed => $price - $coupon->getValue()
            };
        }

        return $price + ($price * $VATNumber->getTax());
    }
}