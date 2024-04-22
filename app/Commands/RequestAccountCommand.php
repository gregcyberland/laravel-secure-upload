<?php

namespace App\Commands;

class RequestAccountCommand
{
    private $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
