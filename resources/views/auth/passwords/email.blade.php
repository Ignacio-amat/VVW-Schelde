@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">
                <div class="rectangle">
                    <div class="text-above-input">
                        <h1>{{ __('Reset Password') }}</h1>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
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
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
                                    @enderror
                                </div>

                                <div class="container">
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
