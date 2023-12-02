@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 rectangle">
                <div class="rectangle">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-above-input">
                                <h1>Register</h1>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <div class="input-field-container">
                                        <input id="name" type="text"
                                               class="form-control input-field @error('name') is-invalid @enderror"
                                               name="name" value="{{ old('name') }}" required autocomplete="name"
                                               placeholder="Name" style="background-color: #FFFFFF;">
                                        <img src="{{ asset('assets/icons/general/user-icon.jpeg') }}" alt="Email Icon"
                                             class="input-icon">
                                    </div>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="input-field-container">
                                        <input id="email" type="email"
                                               class="form-control input-field @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required autocomplete="email"
                                               placeholder="Email Address" style="background-color: #FFFFFF;">
                                        <img src="{{ asset('assets/icons/general/user-icon.jpeg') }}" alt="Email Icon"
                                             class="input-icon">
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>


                                <div class="form-group row">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                    <div class="input-field-container">
                                        <input id="password" type="password"
                                               class="form-control input-field @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password"
                                               placeholder="Password" style="background-color: #FFFFFF; @error('password') border: 5px solid red; @enderror">
                                        <img src="{{ asset('assets/icons/general/lock.jpeg') }}" alt="Password Icon"
                                             class="input-icon">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="input-field-container">
                                        <input id="password-confirm" type="password"
                                               class="form-control input-field"
                                               name="password_confirmation" required autocomplete="new-password"
                                               placeholder="Confirm Password" style="background-color: #FFFFFF; @error('password') border: 5px solid red; @enderror">
                                        <img src="{{ asset('assets/icons/general/lock.jpeg') }}" alt="Password Icon"
                                             class="input-icon">
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="forgot-password-container">
                                        @if (Route::has('password.request'))
                                            <a class="forgot-password" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>

                                    <div class="login-container">
                                        <button type="submit" class="btn btn-primary">
                                            <img src="{{ asset('assets/icons/general/enter.jpeg') }}" alt="Login Icon"
                                                 class="login-icon">
                                        </button>
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
