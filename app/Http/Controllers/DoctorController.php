<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
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

        return view('doctor.index',[
            'donations'=>$donations,
            'user'=>$user,
            'requests'=>$requests
        ]);
    }

    public function create()
    {
        return view('doctor.create_requests');
    }
}
