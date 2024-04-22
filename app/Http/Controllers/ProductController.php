<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\CreateProductCommand;
use App\Commands\UpdateProductCommand;
use App\Queries\ProductSimpleQuery;

class ProductController extends Controller
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function details(int $id)
    {
        // $this->authorize('...')
        $query = new ProductSimpleQuery($id);
        return $query->getData();
    }

    public function create()
    {
        // $this->authorize('...')
        $name = "product 2";
        $price = 150;
        // validation goes here ...

        $command = new CreateProductCommand($name, $price);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function update(int $id)
    {
        $price = 300;
        // validation goes here ...

        $command = new UpdateProductCommand($id, $price);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
