<?php

namespace App\Commands;

class UpdateProductCommand
{
    private $id;
    private $price;

    public function __construct($id, $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    public function getId(): float
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
