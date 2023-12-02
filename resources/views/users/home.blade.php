@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('./css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/users.css') }} ">
    <style>
        .card-header {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            color: darkblue;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Settings') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center">
                            @if ($users->isNotEmpty() && $users->first()->profile_picture_path)
                                <img src="{{ asset('storage/profile_pictures/'.basename($users->first()->profile_picture_path)) }}" alt="Profile Picture" class="img-thumbnail mb-3" width="200">
                            @else
                                <img src="{{ asset('storage/default.jpg') }}" alt="Default Profile Picture" class="img-thumbnail mb-3" width="200">
                            @endif

                            <form action="{{ route('users.update', ['user' => $users->first()]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="file" name="profile_picture" class="form-control-file">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Profile Picture') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
