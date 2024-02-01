<?php

namespace App\Process\ProductFinder;

use App\Lib\Product\Product;
use App\Lib\Product\ProductInterface;
use App\Process\ProductFinder\Exception\ProductNotFoundException;

class MemoryProductFinder implements ProductFinderInterface
{
    private array $products = [];

    public function __construct()
    {
        $this->products[1] = new Product('Iphone', 100);
        $this->products[2] = new Product('Headphones', 20);
        $this->products[3] = new Product('Case', 10);
    }

    public function find(int $id): ProductInterface
    {
        if (!isset($this->products[$id])) {
            throw new ProductNotFoundException();
        }

        return $this->products[$id];
    }
}