<?php

namespace App\Http\Controllers;

use App\Models\Customer1;
use App\Models\Customer2;
use App\Models\RequestAccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class StaffApprove extends Controller
{

    /**
     * Approve a request based on the provided link.
     *
     * @param string $link
     * @return string
     */
    public function approve($link)
    {
        // Decrypt the link and split it into user ID and date parts
        $linkParts = explode('_', Crypt::decryptString($link));
        $userId = $linkParts[0];
        $date = date("Y-m-d H:i:s", strtotime($linkParts[1]));

        // Find the request based on user ID, date, and approval status
        $request = RequestAccess::query()
            ->where('user_id', $userId)
            ->where('date', $date)
            ->where('approved', 0)
            ->first();

        // If the request is found, proceed with approval
        if ($request) {
            $request->approved = 1;
            $request->link = '';

            //set new expiration date
            $request->expiration = date("Y-m-d H:i:s", strtotime($request->requested));;

            $password = rand(100000, 999999) . rand(100000, 999999);
            $request->password = Crypt::encryptString($password);

            // Update customer database and user password, status based on the customer type
            $customer = $this->getCustomer($request->customer);

            $customer = $customer->where('account_type', 'cco')->first();
            $this->updateCustomer($customer, $request->customer, 'approve', $password);

            // Save the request and return success message
            $request->save();
            return 'Request approved successfully!';
        } else {
            abort(404);
        }
    }

}
