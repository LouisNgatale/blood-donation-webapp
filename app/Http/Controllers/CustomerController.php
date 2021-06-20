<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Application|Factory|View|Response
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
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'blood_group' => 'required|String',
            'blood_rha' => 'required|String',
            'required_date' => 'required|date',
            'quantity' => 'required|Integer',
        ]);

        DB::table('requests')
            ->insert([
                'recipient_id'=>auth()->id(),
                'blood_type'=>$request->input('blood_group'),
                'blood_rha'=>$request->input('blood_rha'),
                'required_date'=>$request->input('required_date'),
                'quantity'=>$request->input('quantity'),
            ]);

        return Redirect::route('customer.request')->with('status','Request made successfully!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function donate(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
