<!doctype html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Reset password') }}</title>

    @include('auth.includes.global-head')
</head>


<body class="bg-light">

    <div class="container mt-5">


        <div class="row py-5 mt-5 align-items-center">

            <div class="col-md-6 offset-md-3">

                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/clevada.png') }}" class="img-fluid" alt="{{ config('app.name') }}">
                    <hr>
                </div>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class='fs-5 mb-3'>{{ __('Reset password') }}</div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text login-field" id="addonEmail"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control form-control-lg login-field" placeholder="{{ __('Email') }}" aria-label="{{ __('Email') }}" aria-describedby="addonEmail"
                            @error('email') is-invalid @enderror required autocomplete="email">
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <button type="submit" class="btn btn-primary">{{ __('Reset password') }}</button>

                    <hr>
                    <!-- Already Registered -->
                    <div class="text-center w-100">
                        <p class="text-muted fw-bold">{{ __('Already registered?') }} <a href="{{ route('login') }}" class="text-primary ml-2">{{ __('Login') }}</a></p>
                    </div>
                </form>

            </div>

        </div>

    </div>
</body>

</html>
