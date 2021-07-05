@extends('layouts.customer')

@section('customer')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">Request blood donation appointment</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.donate') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="appointment_date">Appointment date</label>
                                <input type="text" placeholder="MM/DD/YYYY" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment_date" name="appointment_date"
                                       onfocus="(this.type='date')" onblur="(this.type='text')">
                                @error('appointment_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="last_donation">Last donation date</label>
                                <input type="text" placeholder="MM/DD/YYYY" class="form-control @error('last_donation') is-invalid @enderror" id="last_donation" name="last_donation"
                                       onfocus="(this.type='date')" onblur="(this.type='text')">
                                @error('last_donation')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @php
                                use Illuminate\Support\Facades\DB;
                                $zones = DB::table('zones')->get();
                            @endphp
                            <div class="form-group mb-3">
                                <select name="zone_id" class="form-select @error('zone_id') is-invalid @enderror" aria-label="Default select example" required>
                                    <option selected disabled>Choose donation zone...</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->zone }}</option>
                                    @endforeach
                                </select>
                                @error('zone_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ( session('status'))
                                <div class="alert alert-success my-2">
                                    {{ session('status') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger my-2">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">Request</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
