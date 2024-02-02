<?php

namespace App\Tests\Process\CalculatePrice;

use App\Lib\Coupon\Coupon;
use App\Lib\Coupon\CouponType;
use App\Lib\Product\Product;
use App\Lib\VATNumber\VATNumber;
use App\Process\CalculatePrice\CalculatePrice;
use PHPUnit\Framework\TestCase;

class CalculatePriceTest extends TestCase
{

    public function testCalculate()
    {
        $mockProduct = $this->createMock(Product::class);
        $mockProduct->method('getPrice')->willReturn(100.0);

        $mockVATNumber = $this->createMock(VATNumber::class);
        $mockVATNumber->method('getTax')->willReturn(0.24);

        $calculatePrice = new CalculatePrice();
        $price = $calculatePrice->calculate($mockProduct, $mockVATNumber);

        $this->assertSame(124.0, $price);
    }

    public function testCalculateWithCouponPercent()
    {
        $mockProduct = $this->createMock(Product::class);
        $mockProduct->method('getPrice')->willReturn(100.0);

        $mockVATNumber = $this->createMock(VATNumber::class);
        $mockVATNumber->method('getTax')->willReturn(0.24);

        $mockCoupon = $this->createMock(Coupon::class);
        $mockCoupon->method('getType')->willReturn(CouponType::Percent);
        $mockCoupon->method('getValue')->willReturn(0.06);

        $calculatePrice = new CalculatePrice();
        $price = $calculatePrice->calculate($mockProduct, $mockVATNumber, $mockCoupon);

        $this->assertSame(116.56, $price);
    }

    public function testCalculateWithCouponFixed()
    {
        $mockProduct = $this->createMock(Product::class);
        $mockProduct->method('getPrice')->willReturn(100.0);

        $mockVATNumber = $this->createMock(VATNumber::class);
        $mockVATNumber->method('getTax')->willReturn(0.25);

        $mockCoupon = $this->createMock(Coupon::class);
        $mockCoupon->method('getType')->willReturn(CouponType::Fixed);
        $mockCoupon->method('getValue')->willReturn(40.0);

        $calculatePrice = new CalculatePrice();
        $price = $calculatePrice->calculate($mockProduct, $mockVATNumber, $mockCoupon);

        $this->assertSame(75.0, $price);
    }
}
