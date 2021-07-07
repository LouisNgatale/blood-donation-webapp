<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DoctorController extends Controller
{
    public function index()
    {
        $requests = Requests::all()
            ->where('doctor_approved',false)
            ->where('zone_id',User::find(auth()->id())->zone->id)->count();

        $donations = DB::table('donors')
            ->where('donor_id', '=', auth()->id())
            ->count();

        $user = DB::table('users')
            ->where('id', '=', auth()->id())
            ->select('blood_group')
            ->first();

        return view('doctor.index',[
            'donations'=>$donations,
            'user'=>$user,
            'count'=>$requests
        ]);
    }

    public function show()
    {
        $requests = collect(Requests::all()
            ->where('doctor_approved',false)
            ->where('isDenied',false)
            ->where('zone_id',User::find(auth()->id())->zone->id))
            ->map(function ($item) {
                $user =DB::table('users')
                    ->where('id',$item['recipient_id'])
                    ->first();

                $item['name'] = $user->name;
                $item['age'] = $user->age;
                $item['gender'] = $user->gender;

                return $item;
            });

        return view('doctor.requests.index',[
            'requests' => $requests
        ]);
    }


    public function approve($id): RedirectResponse
    {
        // Get the specific request
        DB::table('requests')
            ->where('id', $id)
            ->update([
                'doctor_approved'=>true,
                'doctor_status'=>'updated'
            ]);

        return Redirect::route('doctor.request');
    }

    public function deny($id)
    {
        // Confirm the request is denied
        DB::table('requests')
            ->where('id', $id)
            ->update([
                'doctor_approved'=>false,
                'doctor_status'=>'updated'
            ]);

        return Redirect::route('doctor.request');
    }
}
