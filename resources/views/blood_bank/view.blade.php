@extends('layouts.blood_bank')

@section('blood_bank')
    <div class="container">
        <span class="my-2">Blood stock</span>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Blood group</th>
                        <th scope="col">Expire date</th>
                        <th scope="col">Availability</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $requests as $request )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $request->blood_group }}</td>
                            <td>{{ $request->expire_date }}</td>
                            <td>{{ $request->isAvailable ? 'Available' : 'Not available' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
