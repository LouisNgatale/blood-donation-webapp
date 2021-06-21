<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class RequestsController extends Controller
{

    public function index() {
        $requests = collect(Requests::all()
            ->where('isApproved',false)
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

        if (isset($collection)){
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

    public function approve($id): RedirectResponse
    {
        // Get the specific request
        $request = DB::table('requests')
            ->where('id', $id)
            ->first();

        // Get all available inventories
        $inventories = DB::table('inventories')
            ->where([
                ['blood_rha', '=', $request->blood_rha],
                ['blood_group', '=', $request->blood_type],
                ['isAvailable', '=', true],
            ])->get();

        if ($inventories->isNotEmpty()){
            if ($inventories->count() >= $request->quantity) {
                // Confirm the request is approved
                DB::table('requests')
                    ->where('id', $id)
                    ->update([
                        'isApproved'=>true
                    ]);

                // Update the inventory availability to false
                for ($i = 0; $i < $request->quantity; $i++){
                    $stock_id = $inventories[$i]->id;
                    DB::table('inventories')
                        ->where('id',$stock_id)
                        ->update([
                            'isAvailable'=>false
                        ]);
                }
            }else{
                return Redirect::route('requests.index')->with($id,"No enough stock");
            }
        }else{
            return Redirect::route('requests.index')->with($id,"Out of this stock");
        }
        return Redirect::route('requests.index');
    }

    public function deny($id)
    {
        // Confirm the request is denied
        DB::table('requests')
            ->where('id', $id)
            ->update([
                'isDenied'=>true
            ]);

        return Redirect::route('requests.index');
    }
}
