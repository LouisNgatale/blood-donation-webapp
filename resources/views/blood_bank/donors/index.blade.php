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
                        <th scope="col">Total donations</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $donations as $donation )
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $donation->name }}</td>
                            <td>{{ $donation->age }}</td>
                            <td>{{ $donation->gender }}</td>
                            <td>{{ $donation->blood_group }}</td>
                            <td>{{ $donation->donations }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
