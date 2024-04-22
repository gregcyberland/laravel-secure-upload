<?php

namespace App\Commands\Request;

use Illuminate\Support\Facades\Auth;

class CreateRequestCommand
{
    private $user_id;
    private $date;
    private $expiration;
    private $requested;
    private $customer;
    private $reason;

    public function __construct(
        $user_id,
        $date,
        $expiration,
        $requested,
        $customer,
        $reason
    )
    {
        $this->user_id = $user_id;
        $this->date = $date;
        $this->expiration = $expiration;
        $this->requested = $requested;
        $this->customer = $customer;
        $this->reason = $reason;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getRequested()
    {
        return $this->requested;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getReason()
    {
        return $this->reason;
    }
}
