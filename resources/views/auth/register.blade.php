@extends('layouts.app')

@section('content')
    <div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="text-center" style="color: darkred">BLOOD BANK</h4>
                        <h6 class="text-center">Register</h6>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row mb-2">
                            <div class="col mb-2">
                                <input id="name" placeholder="Name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <div class="col mb-2">
                                <input id="email" placeholder="Email address" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mb-2">
                            <div class="col mb-2">
                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <div class="col mb-2">
                                <input id="password-confirm" placeholder="Confirm password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row mb-2">
                            <div class="col mb-2">
                                <input type="text" placeholder="Age" class="form-control @error('age') is-invalid @enderror" id="age" name="age" >
                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <div class="col mb-2">
                                <input type="text" placeholder="Gender" class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror" aria-label="Default select example" required>
                                <option selected disabled>Blood group...</option>
                                <option value="A">Group A</option>
                                <option value="B">Group B</option>
                                <option value="AB">Group AB</option>
                                <option value="O">Group O</option>
                            </select>
                            @error('blood_group')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

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
                            <span class="invalid-feedback" role="alert">
                                <strong>Choose your zone</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col">
                                <button type="submit" class="btn w-100 btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mt-2 mb-0">
                            <div class="col">
                                <a class="btn w-100" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
