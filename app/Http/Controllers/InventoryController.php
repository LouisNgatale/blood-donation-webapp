<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class InventoryController extends Controller
{
    public function index() {

        $blood_bags = DB::table('inventories')
            ->count();

        $requests = DB::table('requests')
            ->where('isApproved','=',false)
            ->count();

        $donors = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->where('roles.role','=','DONOR')
            ->count();

        return view('blood_bank.index',[
            'blood_bags' => $blood_bags,
            'requests' => $requests,
            'donors' => $donors,
        ]);
    }
    //
    public function create() {
        return view('blood_bank.create');
    }
    //
    public function store(Request $request) {
        $request->validate([
            'blood_group' => 'required|String',
            'blood_rha' => 'required|String',
            'donor_id' => 'required|String',
            'expire_date' => 'required|date',
            'quantity' => 'required|Integer',
        ]);

        $input = $request->input('quantity');
        for ($i = 0; $i < $input;$i++)
        {
            DB::table('inventories')
                ->insert([
                    'blood_group' => $request->input('blood_group'),
                    'blood_rha' => $request->input('blood_rha'),
                    'donor_id' => $request->input('donor_id'),
                    'expire_date' => $request->input('expire_date'),
                    'created_at' => Date::now()
                ]);
        }
        return Redirect::route('blood_bank.create')->with('status','Inventory added successfully!');
    }
}
