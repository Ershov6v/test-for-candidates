<?php

namespace App\Lib\Product;

interface ProductInterface
{
    public function getPrice(): float;

    public function getName(): string;
}