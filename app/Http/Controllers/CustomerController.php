<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $donations = DB::table('donors')
            ->where('donor_id', '=', auth()->id())
            ->count();

        $requests = DB::table('requests')
            ->where('recipient_id', '=', auth()->id())
            ->count();

        $user = DB::table('users')
            ->where('id', '=', auth()->id())
            ->select('blood_group')
            ->first();

        return view('customer.index',[
            'donations'=>$donations,
            'user'=>$user,
            'requests'=>$requests
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function donate(Request $request)
    {
        return view("customer.donation.index");
    }

    public function store(Request $request)
    {
        $dt = new Carbon();
        $before = $dt->subDays(90);

        $request->validate([
            'appointment_date' => 'required|date',
            'last_donation' => 'date|before:' . $before
        ]);

        $model = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.id', '=', Auth::id())
            ->select('roles.role')
            ->get();

        if ($model->firstWhere('role','DONOR')){
            DB::table('appointments')
                ->insert([
                    'appointment_date' =>$request->input('appointment_date'),
                    'last_donation' => $request->input('last_donation'),
                    'zone_id' => $request->input('zone_id'),
                    'user_id' => auth()->id()
                ]);

            return Redirect::route('customer.donate')->with('status','Appointment placed');
        }else{
            $role = DB::table('roles')
                ->where('role', '=', 'DONOR')
                ->first();

            DB::table('role_user')
                ->insert([
                    'user_id'=>Auth::id(),
                    'role_id'=>$role->id
                ]);

            DB::table('appointments')
                ->insert([
                    'appointment_date' =>$request->input('appointment_date'),
                    'last_donation' => $request->input('last_donation'),
                    'zone_id' => $request->input('zone_id'),
                    'user_id' => auth()->id()
                ]);

            return Redirect::route('customer.donate')->with('status','Appointment placed');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
