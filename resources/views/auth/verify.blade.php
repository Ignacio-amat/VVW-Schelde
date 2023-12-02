@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 rectangle">
                <div class="card">
                    <div class="card-header">
                        {{ __('Verify Your Email Address') }}
                    </div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <div class="text-above-input">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </div>

                        <div class="container">
                            <div class="resend-email-container">
                                <form method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link resend-email-link">
                                        {{ __('Click here to request another verification email') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
