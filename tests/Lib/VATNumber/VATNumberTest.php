<?php

namespace App\Tests\Lib\VATNumber;

use App\Lib\VATNumber\Exception\InvalidVATNumberException;
use App\Lib\VATNumber\VATNumber;
use PHPUnit\Framework\TestCase;

class VATNumberTest extends TestCase
{
    public function test__construct()
    {
        $numbers = [
            'DE123456789' => 0.19,
            'IT12345678901' => 0.22,
            'GR123456789' => 0.24,
            'FRHH123456789' => 0.20
        ];

        foreach ($numbers as $number => $tax) {
            $VATNumber = new VATNumber($number);
            $this->assertSame($number, $VATNumber->getNumber());
            $this->assertSame($tax, $VATNumber->getTax());
        }
    }

    public function test__constructWIthException()
    {
        $this->expectException(InvalidVATNumberException::class);

        new VATNumber('TEST');
    }
}
