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

    <div class="container">

        <div class="row py-4 mt-2 align-items-center">

            <div class="text-center mb-3 mt-3">
                <img src="{{ asset('assets/img/logo-auth.png') }}" class="img-fluid" alt="{{ config('app.name') }}">
            </div>

            <div class="col-md-6 offset-md-3 bg-white rounded">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="text-center mb-3 mt-3">
                    <div class='fs-5 fw-bold mb-2 mt-3'>{{ __('Reset password') }}</div>
                </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST">
                    @csrf

                    <label class="fw-bold mb-1">{{ __('Your email') }}</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text login-field" id="addonEmail"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control form-control-lg login-field" placeholder="{{ __('Email address') }}" aria-label="{{ __('Email address') }}" aria-describedby="addonEmail"
                            @error('email') is-invalid @enderror required autocomplete="email">
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">{{ __('Reset password') }}</button>
                    </div>

                    <!-- Divider Text -->
                    <div class="form-group col-lg-12 mx-auto d-flex align-items-center mt-3 mb-2">
                        <div class="border-bottom w-100 "></div>
                        <span class="px-2 small text-muted font-weight-bold text-muted">{{ __('OR') }}</span>
                        <div class="border-bottom w-100 "></div>
                    </div>

                    <!-- Already Registered -->
                    <div class="text-center w-100">
                        <p class="text-muted">{{ __('Already registered?') }} <a href="{{ route('login') }}" class="text-primary ml-2">{{ __('Login') }}</a></p>
                    </div>
                </form>

            </div>

        </div>

        @include('auth.includes.copyright')

    </div>
</body>

</html>
