<?php

namespace App\Queries;

use App\Models\Product;

class ProductSimpleQuery
{
    private $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function getData(): array
    {
        $product = Product::query()->findOrFail($this->productId);
        return [
            'name' => $product->name,
            'price' => $product->price,
        ];
    }
}
