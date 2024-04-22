<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

abstract class Controller
{
    public function getCustomer($customer)
    {
        $modelName = 'App\\Models\\' . ucfirst($customer);
        return $modelName::query();
    }

    public function updateCustomer($customerModel, $customerData, $action, $newPassword = null)
    {
        if ($newPassword === null) {
            $newPassword = rand(100000, 999999) . rand(100000, 999999);
        }

        if ($customerModel) {
            // Check if customer has 'L' character
            if (str_contains($customerData, 'L')) {
                $customerModel->password = Hash::make($newPassword);
            } else {
                $customerModel->password = md5($newPassword);
            }

            if ($action == 'end') {
                $customerModel->status = 0;
                //log out user
                if (str_contains($customerData, 'L')) {
                    DB::connection($customerModel->getConnectionName())->table('sessions')->where('user_id', $customerModel->id)->delete();
                }
            } else {
                $customerModel->status = 1;
            }

            $customerModel->save();
        } else {
            abort(422, 'Something went wrong!');
        }
    }

}
