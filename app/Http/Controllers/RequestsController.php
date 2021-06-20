<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
    //
    public function index() {

        $requests = collect(Requests::all()->where('isApproved','=',false))
            ->map(function ($item) {

                $user =DB::table('users')
                    ->where('id',$item['recipient_id'])
                    ->first();

                 $item['name'] = $user->name;
                 $item['age'] = $user->age;
                 $item['gender'] = $user->gender;

                 return $item;
            });

        return view('blood_bank.requests.index',[
            'requests' => $requests
        ]);
    }
}
