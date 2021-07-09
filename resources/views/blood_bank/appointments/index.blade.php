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
                        <th scope="col">Appointment date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $appointments as $appointment )
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $appointment->name }}</td>
                            <td>{{ $appointment->age }}</td>
                            <td>{{ $appointment->gender }}</td>
                            <td>{{ $appointment->blood_group }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>
                                <div>
                                    <div>
                                        <form class="d-inline" action="{{ route("appointments.approve",$appointment->id) }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-success" value="Approve">
                                        </form>

                                        <form class="d-inline" action="{{ route("appointments.deny",$appointment->id) }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-danger" value="Deny">
                                        </form>
                                    </div>
                                    @if (session($appointment->id))
                                        <span class="text-danger my-2">
                                        {{ session($appointment->id) }}
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
