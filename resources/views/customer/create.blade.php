@extends('layouts.customer')

@section('customer')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">Request blood donation</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="blood_group">Blood Group</label>
                                <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror" aria-label="Default select example" required>
                                    <option selected disabled>Choose...</option>
                                    <option value="A+">Group A+</option>
                                    <option value="A-">Group A-</option>
                                    <option value="B+">Group B+</option>
                                    <option value="B-">Group B-</option>
                                    <option value="AB+">Group AB+</option>
                                    <option value="AB-">Group AB-</option>
                                    <option value="O+">Group O+</option>
                                    <option value="O-">Group O-</option>
                                </select>
                                @error('blood_group')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="required_date">Required date</label>
                                <input type="text" placeholder="MM/DD/YYYY" class="form-control @error('required_date') is-invalid @enderror" id="required_date" name="required_date"
                                       onfocus="(this.type='date')" onblur="(this.type='text')">
                                @error('expire_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="Number of blood bags">
                                @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

<!--                            <div class="form-group mb-3">
                                <label for="request_code">Request code</label>
{{--                                <input type="text" name="request_code" id="request_code" class="form-control @error('request_code') is-invalid @enderror" placeholder="eg REQ-2000-450">--}}
                                <small>Enter the request code given by the doctor</small>
{{--                                @error('request_code')--}}
{{--                                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}
                            </div>-->

                            @php
                                use Illuminate\Support\Facades\DB;
                                $zones = DB::table('zones')->get();
                            @endphp
                            <div class="form-group mb-3">
                                <select name="zone_id" class="form-select @error('zone_id') is-invalid @enderror" aria-label="Default select example" required>
                                    <option selected disabled>Choose your zone...</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->zone }}</option>
                                    @endforeach
                                </select>
                                @error('zone_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Request</button>
                        </form>
                        @if ( session('status'))
                            <div class="alert alert-success my-2">
                                {{ session('status') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger my-2">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
