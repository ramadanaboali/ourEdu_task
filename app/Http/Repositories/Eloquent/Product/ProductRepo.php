<?php

namespace App\Http\Repositories\Eloquent\Product;

use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Http\Repositories\Interfaces\Product\ProductRepoInterface;
use App\Models\Product;


class ProductRepo extends AbstractRepo implements ProductRepoInterface
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }
}
