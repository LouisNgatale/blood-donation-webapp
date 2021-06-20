<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Support\Facades\DB;

class DonorsController extends Controller
{
    //
    public function index() {
        $donors = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->where('roles.role','=','DONOR')
            ->get();

        $donors = json_decode(json_encode($donors), true);

        $requests = collect($donors)
            ->map(function ($item) {
                $donations = DB::table('donors')
                    ->where('donor_id', '=', $item['id'])
                    ->first();

                $item['donations'] = $donations->donations ;
                return $item;
            });

        return view('blood_bank.donors.index',[
            'donations' => json_decode(json_encode($requests))
        ]);
    }
}
