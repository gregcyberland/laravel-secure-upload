<?php

namespace App\Commands;

use App\Models\Product;

class UpdateProductHandler
{
    public function __invoke(UpdateProductCommand $command)
    {
        $product = Product::query()->findOrFail($command->getId());
        $product->price = $command->getPrice();
        $product->save();
    }
}
