<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\Request\CreateRequestCommand;
use App\Mail\MailApprove;
use App\Models\RequestAccess;
use App\Models\User;
use App\Queries\RequestQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Http\Customer\Customer;

class StaffController extends Controller
{

    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
//        if(Auth::user()->account != 'staff'){
//            abort(403, 'Unauthorized action.');
//        }
        $this->commandBus = $commandBus;
    }

    public function index()
    {
        Artisan::call('app:update-users');

        //get all request filter by current user
        $query = new RequestQuery(Auth::id());
        //get current user active session
        $queryActiveSession = RequestAccess::query()
            ->where('expiration', '>', date("Y-m-d H:i:s", time()))
            ->get();

        //get all customer
        $controller = new Customer();
        $customers = $controller->allCustomer();

        return view('staff.index', [
            'request' => $query->getData()->get(),
            'activeSession' => $queryActiveSession,
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {

        $request = request();

        $user_id = Auth::id();
        $date = time();
        $requested = $request->time;
        $expiration = date("Y-m-d H:i:s", strtotime($requested));
        $customer = $request->customer;
        $reason = $request->reason;

        //check if there is active session
        $hasActiveSession = RequestAccess::query()
            ->where('customer', $customer)
            ->where('expiration', '>', date("Y-m-d H:i:s", time()))
            ->exists();

        //check if already requested
        $checkRequested = RequestAccess::query()
            ->where('customer', $customer)
            ->where('user_id', $user_id)
            ->where('link', '!=', '')
            ->exists();

        if($checkRequested){
            return Redirect::back()->with('error', 'You have already requested!');
        }

        if($hasActiveSession){
            return Redirect::back()->with('error', 'There is an active session for '.ucwords($customer).'! please check the active session!');
        }

        $command = new CreateRequestCommand(
            $user_id,
            $date,
            $expiration,
            $requested,
            $customer,
            $reason,
        );
        $this->commandBus->handle($command);

        //email part
        $user = auth()->user();
        $link = Crypt::encryptString($user_id . '_' . date("Y-m-d H:i:s", $date));
        //Mail::to($this->getAdminEmail())->send(new MailApprove($user->name, $user->email, $expiration, $link));

        return Redirect::back()->with('message', 'Request created successfully!');
    }


    public function history()
    {
        //get staff history
        $user = auth()->user();
        $query = RequestAccess::query()->where('user_id', $user->id)->get();
        return view('staff.history', [
            'requests' => $query
        ]);
    }

    public function endsession(Request $request)
    {
        $request = request();

        // find by id
        $request = RequestAccess::query()->find($request->id);

        if ($request) {
            $request->expiration = date("Y-m-d H:i:s", time());

            // Update customer database and user password, status based on the customer type
            $customer = $this->getCustomer($request->customer);

            $customer = $customer->where('account_type', 'cco')->first();
            $this->updateCustomer($customer, $request->customer, 'end');

            $request->save();
            return Redirect::back()->with('message', 'Session ended!');
        } else {
            return 'Error ending session!';
        }

    }

    public function getAdminEmail()
    {
        return User::query()->where('account', 'admin')->first()->email;
    }

}
