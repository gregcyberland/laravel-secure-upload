<?php

namespace App\Commands\Request;

use App\Models\RequestAccess;
use Illuminate\Support\Facades\Hash;

class CreateRequestHandler
{
    public function __invoke(CreateRequestCommand $command)
    {
        $request = new RequestAccess();
        $request->user_id = $command->getUserId();
        $request->date = date("Y-m-d H:i:s", $command->getDate());
        $request->customer = $command->getCustomer();
        $request->reason = $command->getReason();
        $request->expiration = $command->getExpiration();
        $request->requested = $command->getRequested();
        $request->link = Hash::make($command->getUserId().'-'.date("Y-m-d H:i:s", $command->getDate()));
        $request->save();
    }
}
