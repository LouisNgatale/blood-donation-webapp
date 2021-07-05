@extends('layouts.blood_bank')

@section('blood_bank')
    <div class="container">

        <h4 class="d-block text-dark mb-2">
            Blood bank general summary
        </h4>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block font-15 text-dark font-weight-500">Available blood Bags</span>
                        <div class="text-center">
                            @if($blood_bags < 10)
                                <p class="text-danger alert-danger">Stock is very low</p>
                            @endif
                            <span class="d-block display-4 text-dark mb-5">

                                {{ $blood_bags }}
                            </span>
                            <small class="d-block">
                                Listed Blood Bags
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block font-15 text-dark font-weight-500">Pending requests</span>
                        <div class="text-center">
                            <span class="d-block display-4 text-dark mb-5">
                                {{ $requests }}
                            </span>
                            <small class="d-block">
                                Listed pending requests
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block font-15 text-dark font-weight-500">Available donors</span>
                        <div class="text-center">
                            <span class="d-block display-4 text-dark mb-5">
                                {{ $donors }}
                            </span>
                            <small class="d-block">
                                Listed Registered donors
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-4">
                <a href="{{ route('blood_bank.create') }}" class="btn btn-outline-primary">Add Stock</a>
                <a href="{{ route('blood_bank.view') }}" class="btn ml-2 btn-outline-primary">View Stock</a>
            </div>
            <div class="col-4">
                <a href="{{ route('requests.index') }}" class="btn btn-outline-primary">View requests</a>
            </div>
            <div class="col-4">
                <a href="{{ route('donors.index') }}" class="btn btn-outline-primary">View donors</a>
            </div>
        </div>
    </div>
@endsection
