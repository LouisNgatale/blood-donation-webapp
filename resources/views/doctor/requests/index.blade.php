@extends('layouts.doctor')

@section('doctor')
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
                        <th scope="col">Action</th>
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
                        <td>
                            <div>
                                <div>
                                    <form class="d-inline" action="{{ route("doctor_requests.approve",$request->id) }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-success" value="Approve">
                                    </form>

                                    <form class="d-inline" action="{{ route("doctor_requests.deny",$request->id) }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-danger" value="Deny">
                                    </form>
                                </div>
                                @if (session($request->id))
                                    <span class="text-danger my-2">
                                        {{ session($request->id) }}
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
