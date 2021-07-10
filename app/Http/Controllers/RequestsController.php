<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Jimmyjs\ReportGenerator\ReportMedia\PdfReport;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class RequestsController extends Controller
{

    public function index() {
        $requests = collect(Requests::all()
            ->where('doctor_approved',true)
            ->where('isApproved',false)
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
            'required_date' => 'required|date',
            'zone_id' => 'required',
            'quantity' => 'required|Integer',
        ]);
        DB::table('requests')
            ->insert([
                'recipient_id'=>auth()->id(),
                'blood_type'=>$request->input('blood_group'),
                'zone_id'=>$request->input('zone_id'),
//                    'request_code_id'=>$collection->id,
                'required_date'=>$request->input('required_date'),
                'quantity'=>$request->input('quantity'),
            ]);
        return Redirect::route('customer.request')->with('status','Request made successfully!');
/*
        $collection = DB::table('request_codes')
            ->where('request_code', '=', $request->input('request_code'))
            ->where('owner_id', '=', auth()->id())->first();*/

//        if (isset($collection)){

//        }else{
//            return Redirect::route('customer.request')->with('error','The request code is not valid!');
//        }
    }
    function get_customer_data()
    {
        return collect(Requests::all())
            ->map(function ($item) {
                $user =DB::table('users')
                    ->where('id',$item['recipient_id'])
                    ->first();

                $item['name'] = $user->name;
                $item['age'] = $user->age;
                $item['gender'] = $user->gender;

                return $item;
            });
    }

    function pdf()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html());
        return $pdf->stream();
    }

    function convert_customer_data_to_html()
    {
        $customer_data = $this->get_customer_data();
        $output = '
                 <h3 align="center">Blood requests report</h3>
                 <table width="100%" style="border-collapse: collapse; border: 0px;">
                  <tr>
                <th scope="col">Name</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
                <th scope="col">Blood Group</th>
                <th scope="col">Status</th>
                <th scope="col">Quantity</th>
               </tr>
                 ';
        foreach($customer_data as $customer)
        {
            $output .= '
                      <tr>
                       <td style="border: 1px solid; padding:12px;">'.$customer->name.'</td>
                       <td style="border: 1px solid; padding:12px;">'.$customer->age.'</td>
                       <td style="border: 1px solid; padding:12px;">'.$customer->gender.'</td>
                       <td style="border: 1px solid; padding:12px;">'.$customer->blood_type.'</td>
                       <td style="border: 1px solid; padding:12px;">Pending</td>
                       <td style="border: 1px solid; padding:12px;">'.$customer->quantity.'</td>
                      </tr>
                      ';
        }
        $output .= '</table>';
        return $output;
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


    public function displayReport()
    {
        $title = 'Donation requests'; // Report title

//        $queryBuilder = DB::table('users')
//            ->join('requests','requests.recipient_id','=','users.id')
////            ->join('zones','requests.zone_id','=','zones.id')
//            ->select('name','blood_type','doctor_status','required_date');

        $queryBuilder = Requests::select(['blood_type', 'doctor_status', 'required_date']); // You should sort groupBy column to use groupBy();

        $columns = [ // Set Column to be displayed
            'Blood Group'=>'blood_type', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            'Status' => 'doctor_status',
            'Required date' => 'required_date'
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return (new \Jimmyjs\ReportGenerator\ReportMedia\PdfReport)->of($title, [], $queryBuilder, $columns)
            /*->editColumn('Required date', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function($result) {
                    return $result->required_date->format('d M Y');
                },
                'class' => 'left'
            ])*/
            ->editColumns(['Blood Type', 'Status'], [ // Mass edit column
                'class' => 'right bold'
            ])
            ->limit(20) // Limit record to be showed
            ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
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
                ['blood_group', '=', $request->blood_type],
                ['isAvailable', '=', true],
            ])->get();


        // Handle out of stock error
        if ($inventories->isNotEmpty()){
            // Handle not enough error
            if ($inventories->count() >= $request->quantity) {
                // Confirm the request is approved
                DB::table('requests')
                    ->where('id', $id)
                    ->update([
                        'isApproved'=>true,
                        'admin_status'=>'updated'
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
                return Redirect::route('requests.index')->with($id,"Approved");
            }else{
                return Redirect::route('requests.index')->with($id,"No enough stock");
            }
        }else{
            return Redirect::route('requests.index')->with($id,"Out of this stock");
        }
    }

    public function deny($id)
    {
        // Confirm the request is denied
        DB::table('requests')
            ->where('id', $id)
            ->update([
                'isDenied'=>true,
                'admin_status'=>'updated'
            ]);

        return Redirect::route('requests.index');
    }
}
