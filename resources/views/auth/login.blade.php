@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">
                <div class="rectangle">
                    <div class="text-above-input">
                        <h1>Log in</h1>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Redirect back to the original page -->
                                @if (request()->has('redirectTo'))
                                    <input type="hidden" name="redirectTo" value="{{ request()->input('redirectTo') }}">
                                @endif


                                <div class="form-group">
                                    @error('email')
                                    <strong class="invalid-feedback" role="alert">{{ $message }}</strong>
                                    @enderror
                                    <div class="input-field-container">
                                        <input id="email" type="email"
                                               class="form-control input-field @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email') }}" required autocomplete="email"
                                               placeholder="Email"
                                               autofocus
                                               style="background-color: #FFFFFF; @error('email') border: 5px solid red; @enderror">
                                        <img src="{{ asset('assets/icons/general/user-icon.jpeg') }}" alt="Email Icon"
                                             class="input-icon">
                                    </div>
                                </div>

                                <div class="form-group">
                                    @error('email')
                                    <strong class="invalid-feedback" role="alert">{{ $message }}</strong>
                                    @enderror
                                    <div class="input-field-container">
                                        <input id="password" type="password"
                                               class="form-control input-field @error('email') is-invalid @enderror"
                                               name="password" required autocomplete="current-password"
                                               placeholder="Password"
                                               style="background-color: #FFFFFF; @error('email') border: 5px solid red; @enderror">
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
