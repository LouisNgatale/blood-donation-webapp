@extends('layouts.blood_bank')

@section('blood_bank')
    <div class="container">
        <span class="my-2">All Requests</span>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Blood Group</th>
                        <th scope="col">Status</th>
                        <th scope="col">Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $requests as $request )
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->age }}</td>
                        <td>{{ $request->gender }}</td>
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
