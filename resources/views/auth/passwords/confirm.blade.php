@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">
                <div class="rectangle">
                    <div class="text-above-input">
                        <h1>{{ __('Confirm Password') }}</h1>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            {{ __('Please confirm your password before continuing.') }}

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="form-group">
                                    <div class="input-field-container">
                                        <input id="password" type="password"
                                               class="form-control input-field @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password"
                                               placeholder="{{ __('Password') }}"
                                               style="background-color: #FFFFFF; @error('password') border: 5px solid red; @enderror">
                                        <img src="{{ asset('assets/icons/general/lock.jpeg') }}" alt="Password Icon"
                                             class="input-icon">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>

                                <div class="container">
                                    <div class="login-container">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Confirm Password') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
