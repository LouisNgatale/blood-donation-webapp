@extends('layouts.customer')

@section('customer')
    <div class="container">
        <span class="my-2">All Requests</span>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Doctor Status</th>
                        <th scope="col">Doctor Decision</th>
                        <th scope="col">Blood bank Status</th>
                        <th scope="col">Blood Group</th>
                        <th scope="col">Status</th>
                        <th scope="col">Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $requests as $request )
                    <tr>
                        <th scope="row">1</th>
                        @if($request->doctor_status == "updated")
                            <td>Doctor Reviewed</td>
                        @else
                            <td>Pending doctor review</td>
                        @endif

                        @if(!$request->doctor_approved && $request->doctor_status == "updated")
                            <td>Doctor denied</td>
                        @elseif($request->doctor_approved)
                            <td>Doctor approved</td>
                        @elseif(!$request->doctor_approved && $request->doctor_status != "updated")
                            <td>Pending doctor review</td>
                        @endif

                        @if($request->is_denied && $request->admin_status == "updated")
                            <td>Blood bank denied</td>
                        @elseif($request->is_approved)
                            <td>Blood bank approved</td>
                        @elseif(!$request->is_approved && $request->admin_status == "pending")
                            <td>Pending blood bank review</td>
                        @endif

                        <td>{{ $request->blood_type }}</td>
                        <td>Pending</td>
                        <td>{{ $request->quantity }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
