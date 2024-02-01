<?php

namespace App\Process\ProductFinder\Exception;

use Exception;

class ProductNotFoundException extends Exception
{
    protected $message = 'Product not found';
}