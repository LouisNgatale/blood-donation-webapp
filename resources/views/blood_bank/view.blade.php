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
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $requests as $request )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $request->blood_group }}</td>
                            @php
                                $date = new \Carbon\Carbon( $request->expire_date);
                            @endphp

                            @if($date->isPast())
                                <td ><p class="alert-danger p-1 text-danger">{{ $request->expire_date }}</p></td>
                            @else
                                <td>{{ $request->expire_date }}</td>
                            @endif
                            <td>{{ $request->isAvailable ? 'Available' : 'Not available' }}</td>
                            <td>
                                @if($date->isPast())
                                <form class="d-inline" action="{{ route("blood_bank.remove",$request->id) }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger" value="Remove">
                                </form>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
