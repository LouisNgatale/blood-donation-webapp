<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\isEmpty;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'blood_group' => 'required|String',
            'blood_rha' => 'required|String',
            'required_date' => 'required|date',
            'zone_id' => 'required',
            'quantity' => 'required|Integer',
            'request_code' => 'required',
        ]);

        $collection = DB::table('request_codes')
            ->where('request_code', '=', $request->input('request_code'))
            ->where('owner_id', '=', auth()->id())->first();

        if ($collection->id){
            DB::table('requests')
                ->insert([
                    'recipient_id'=>auth()->id(),
                    'blood_type'=>$request->input('blood_group'),
                    'blood_rha'=>$request->input('blood_rha'),
                    'zone_id'=>$request->input('zone_id'),
                    'request_code_id'=>$collection->id,
                    'required_date'=>$request->input('required_date'),
                    'quantity'=>$request->input('quantity'),
                ]);
            return Redirect::route('customer.request')->with('status','Request made successfully!');

        }else{
            return Redirect::route('customer.request')->with('error','The request code is not valid!');
        }



    }

    public function request_code(Request $request)
    {
        $request->validate([
            'blood_group' => 'required|String',
            'blood_rha' => 'required|String',
            'required_date' => 'required|date',
            'zone_id' => 'required',
            'quantity' => 'required|Integer',
            'patient_id' => 'required|Integer',
        ]);

        $code = 'REQ-'
            .$request->input('zone_id')."-"
            .mt_rand(1000, 9999). "-"
            .$request->input('blood_group')
            .$request->input('patient_id')."-"
            .auth()->id();

        DB::table('request_codes')
            ->insert([
                'request_code'=>$code,
                'owner_id'=>$request->input('patient_id'),
                'generated_by'=>auth()->id()
            ]);

        return Redirect::route('doctor.request')->with('status',"Request code - $code");
    }
}
