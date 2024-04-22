<?php

namespace App\Console\Commands;

use App\Http\Customer\Customer;
use App\Models\Link;
use App\Models\RequestAccess;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiration date of users and update them.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new Customer();
        $customers = $controller->allCustomer();

        foreach ($customers as $customer) {
            $this->processCustomer($customer);
        }

        //remove all link that has expired
        $checkLink = RequestAccess::query()
            ->where('link', '!=', '')->get();

        $test = [];
        $linkExpiration = Link::query()->first()->hours;
        foreach ($checkLink as $customer) {
            $dateExpire = Carbon::parse($customer->date)->addHours($linkExpiration)->format('Y-m-d H:i:s');
            if($dateExpire <= date("Y-m-d H:i:s", time())){
               $test[] = 1;
                RequestAccess::query()->where('id', $customer->id)->update([
                    'link' => ''
                ]);
           }else{
               $test[] = 0;
           }
        }

    }


    public function processCustomer($customerType)
    {
        $customer = RequestAccess::query()
            ->where('customer', $customerType)
            ->where('expiration', '>', date("Y-m-d H:i:s", time()))
            ->get();

        if($customer->count() === 0){
            $password = rand(100000, 999999) . rand(100000, 999999);

            $model = $this->getCustomer($customerType);

            $model = $model->where('account_type' , 'cco')
                ->where('status', 1);

              if (str_contains($customerType, 'L')) {
                  //log out user
                  DB::connection($customerType)
                      ->table('sessions')
                      ->join('users', 'sessions.user_id', '=', 'users.id')
                      ->where('users.account_type', 'cco')
                      ->where('users.status', 1)
                      ->delete();

                  $model->update([
                      'password' => Hash::make($password),
                      'status' => 0
                  ]);
              } else {
                  $model->update([
                      'password' => md5($password),
                      'status' => 0
                  ]);
              }

        }
    }

    public function getCustomer($customer)
    {
        $modelName = 'App\\Models\\' . ucfirst($customer);
        return $modelName::query();
    }
}

