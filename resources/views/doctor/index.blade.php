@extends('layouts.doctor')

@section('doctor')
    <div class="container">
        <h4 class="d-block text-dark mb-2">
            Welcome, Doctor {{ Auth::user()->name }}
        </h4>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block font-15 text-dark font-weight-500">Total donations made</span>
                        <div class="text-center">
                            <span class="d-block display-4 text-dark mb-5">
                                {{ $donations }}
                            </span>
                            <small class="d-block">
                                Listed number of donations
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block font-15 text-dark font-weight-500">Total blood requests</span>
                        <div class="text-center">
                            <span class="d-block display-4 text-dark mb-5">
                                {{ $requests }}
                            </span>
                            <small class="d-block">
                                Listed number of requests
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block font-15 text-dark font-weight-500">Blood Group</span>
                        <div class="text-center">
                            <span class="d-block display-4 text-dark mb-5">
                                {{ $user->blood_group }}
                            </span>
                            <small class="d-block">
                                Listed Blood group
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-4">
                <a href="{{ route('doctor.request') }}" class="btn btn-outline-primary">Generate request code</a>
            </div>
        </div>
    </div>
@endsection
