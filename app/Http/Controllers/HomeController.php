<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        if (Auth::check()) {
            $collection = DB::table('users')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.id', '=', \auth()->id())
                ->select('roles.role')
                ->get();

            $json_decode = json_decode($collection, true);

            if ($json_decode[0]['role'] == "CUSTOMER") {
                return Redirect::route( "customer.home");
            }
            if ($json_decode[0]['role'] == "DONOR") {
                return Redirect::route( "customer.home");
            }
            if ($json_decode[0]['role'] == "ADMIN") {
                return Redirect::route( "blood_bank.home");
            }
            if ($json_decode[0]['role'] == "DOCTOR") {
                return Redirect::route( "doctor.home");
            }
        }else{
            return view('home');
        }
    }
}
