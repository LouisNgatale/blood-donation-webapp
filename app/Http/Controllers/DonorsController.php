<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DonorsController extends Controller
{

    public function index() {
        $donors = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->where('roles.role','=','DONOR')
            ->get();

        $donors = json_decode(json_encode($donors), true);

        $requests = collect($donors)->map(function ($item) {
            $donors = DB::table('donors')
                ->where('donor_id', '=', $item['id'])
                ->first();

            $item['donations'] = $donors['donations'] ?? '0';

            return $item;
            });

        return view('blood_bank.donors.index',[
            'donations' => json_decode(json_encode($requests))
        ]);
    }

    public function appointments()
    {
        $donors = DB::table('users')
            ->join('appointments','users.id','=','appointments.user_id')
            ->where('appointments.zone_id',User::find(\auth()->id())->zone['id'])
            ->get();

        $donors = json_decode(json_encode($donors), true);

        $requests = collect($donors)->map(function ($item) {
            $donors = DB::table('donors')
                ->where('donor_id', '=', $item['id'])
                ->first();

            $item['donations'] = $donors['donations'] ?? '0';

            return $item;
        });

        return view('blood_bank.appointments.index',[
            'appointments' => json_decode(json_encode($requests))
        ]);
    }

    public function approve($id): RedirectResponse
    {
        // Get the specific request
        DB::table('appointments')
            ->update([
                'status' => 'approved'
            ]);

        return Redirect::route('donors.appointments')->with($id,"Approved");
    }

    public function deny($id)
    {
        // Get the specific request
        DB::table('appointments')
            ->update([
                'isApproved' => 'denied'
            ]);

        return Redirect::route('donors.appointments')->with($id,"Denied");
    }
}
