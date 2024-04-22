<?php

namespace App\Queries;

use App\Models\RequestAccess;

class RequestQuery
{
    private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function getData()
    {
        return RequestAccess::query()
            ->where('user_id', $this->user_id)
            ->where('expiration', '>', date("Y-m-d H:i:s", time()));
    }
}
