@extends('layouts.app')

@section('content')
    <div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row justify-content-center">
                            <img src="{{ asset("droplet.png") }}" class="w-75" alt="">
                        </div>
                        <div class="mb-3">
                            <h4 class="text-center" style="color: darkred">BLOOD BANK</h4>
                            <h6 class="text-center">Login</h6>
                        </div>
                        <div class="form-group row">
                            <div class="col mb-2">
                                <input id="email" type="email" placeholder="Email address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col">
                                <button  type="submit" class="btn w-100 btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="form-group row mt-2 mb-0">
                            <div class="col">
                                <a class="btn w-100" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
