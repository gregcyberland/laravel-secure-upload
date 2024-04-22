<?php

namespace App\Http\Controllers;


use App\Http\Customer\Customer;
use App\Models\link;
use App\Models\RequestAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller
{

    /**
     * Constructor function to check if the current user has admin privileges
     */
    public function __construct()
    {
        if(Auth::user()->account != 'admin'){
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Retrieve all request accesses from the database
     *
     * @return view
     */
    public function index()
    {
        Artisan::call('app:update-users');

        // Retrieve all request accesses from the database
        $requests = RequestAccess::all();

        // Render the admin index view with the retrieved request accesses
        return view('admin.index', [
            'requests' => $requests
        ]);
    }

    public function settings()
    {
        //get the link expiration hours
        $link_expiration = Link::query()->first()->hours;

        // Render the admin settings
        return view('admin.settings',[
            'link_expiration' => $link_expiration
        ]);
    }

    public function uppdateLinkExpiration()
    {
        Link::query()->find(1)->update(['hours' => request('link')]);
        return Redirect::back()->with('message', 'Link Expiration updated successfully!');
    }

    public function addtime(Request $request)
    {
        //add time to the current user
        $updateUserExpiration = RequestAccess::query()->where('id', $request->id)->first();

        $expiration = Carbon::parse($updateUserExpiration->expiration);
        $timeToAdd = intval($request->time);
        $newExpiration = $expiration->addHours($timeToAdd);

        $updateUserExpiration->update(['expiration' => $newExpiration->format('Y-m-d H:i:s')]);

        return Redirect::back()->with('message', 'Time added successfully!');
    }

    public function killAll()
    {
        return view('admin.killall');
    }

    public function logoutAll(Request $request)
    {
       //check admin password if match from users table
        $password = Auth::user()->password;
        $adminPassword = $request->password;

        if(Hash::check($adminPassword, $password)){
            //log out all users
            $controller = new Customer();
            $customers = $controller->allCustomer();

            foreach ($customers as $customer) {
                $model = $this->getCustomer($customer);
                $password = rand(100000, 999999) . rand(100000, 999999);

                if (str_contains($customer, 'L')) {
                    DB::connection($customer)
                        ->table('sessions')
                        ->where('id', '!=',  '')
                        ->delete();

                    $model->update([
                        'password' => Hash::make($password),
                        'status' => 0
                    ]);
                }else{
                    $model->where('account_type' , 'cco')
                        ->update([
                            'password' => md5($password),
                            'status' => 0
                        ]);
                }

                RequestAccess::query()
                    ->where('approved', 1)
                    ->where('expiration', '>', date("Y-m-d H:i:s", time()))
                    ->update(
                        ['expiration' => date("Y-m-d H:i:s", time())]
                    );

            }

            return Redirect::back()->with('message', 'All users logged out successfully!');
        }else{
            return Redirect::back()->with('error', 'Admin password does not match!');
        }
    }


    public function getCustomer($customer)
    {
        $modelName = 'App\\Models\\' . ucfirst($customer);
        return $modelName::query();
    }

}
