<?php

namespace App\Process\ProductFinder;

use App\Lib\Product\ProductInterface;

interface ProductFinderInterface
{
    public function find(int $id): ProductInterface;
}