<!doctype html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Create an account') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets/img/favicon.png') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('/assets/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <script src="{{ asset('/assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    
</head>

<body class="bg-light">

    <style>
        .alert ul {
            margin-bottom: 0 !important;
        }

        .select2-results__options::-webkit-scrollbar {
            width: 16px;
            background-clip: padding-box;
        }

        .select2-results__options::-webkit-scrollbar-track {
            background-color: #F4F4F4;
            height: 8px;
            background-clip: padding-box;
            border-right: 10px solid rgba(0, 0, 0, 0);
            border-top: 10px solid rgba(0, 0, 0, 0);
            border-bottom: 10px solid rgba(0, 0, 0, 0);
        }

        .select2-results__options::-webkit-scrollbar-thumb {
            background-clip: padding-box;
            background-color: #0F2464;
            border-right: 10px solid rgba(0, 0, 0, 0);
            border-top: 10px solid rgba(0, 0, 0, 0);
            border-bottom: 10px solid rgba(0, 0, 0, 0);
        }

        .select2-results__options::-webkit-scrollbar-button {
            display: none;
        }
    </style>


    <div class="container">

        <div class="row py-4 mt-2 align-items-center">

            <div class="col-md-6 offset-md-3 bg-white rounded">

                <div class="text-center mb-3 mt-3">
                    <a target="_blank" href="{{ route('home') }}"><img src="{{ asset('assets/img/clevada.png') }}" class="img-fluid" alt="{{ config('app.name') }}"></a>
                </div>

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        @if ($message == 'registration_disabled')
                            {{ __('Registration is disabled') }}
                        @endif
                        @if ($message == 'invalid_email')
                            {{ __('This email is not available') }}
                        @endif
                    </div>
                @endif

                @error('recaptcha')
                    <div class="text-danger">
                        <strong>{{ __('Antispam error') }}</strong>
                    </div>
                @enderror

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class='fs-5 fw-bold mb-2 text-center'>{{ __('Create :app_name account.', ['app_name' => config('app.name')]) }}</div>

                <hr>

                <form method="POST" action="{{ route('register') }}" autocomplete="off" id="registerForm">
                    @csrf

                    <div class="row">

                        <!-- Name -->
                        <div class="col-12 mb-3">
                            <label class="fw-bold mb-1">{{ __('Your name') }}</label>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonName"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="{{ __('Nume') }}" aria-label="{{ __('Nume') }}" aria-describedby="addonName"
                                    @error('name') is-invalid @enderror require autocomplete="off" value="{{ old('name') }}">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12 mb-3">
                            <label class="fw-bold mb-1">{{ __('Email') }}</label>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonEmail"><i class="bi bi-person"></i></span>
                                <input type="text" name="email" id="email" class="form-control form-control-lg" placeholder="" aria-label="{{ __('Email') }}" aria-describedby="addonEmail" minlength="8"
                                    maxlength="50" @error('email') is-invalid @enderror required autocomplete="off" value="{{ old('email') }}">                                
                            </div>
                            <div class="form-text text-muted small">{{ __("Input your valid email. You must verify your email after registration.") }}</div>                            
                        </div>
                       

                        <!-- Password -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonPw"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="{{ __('Parola') }}" aria-label="{{ __('Password') }}" aria-describedby="addonPw"
                                    @error('password') is-invalid @enderror required minlength="8" autocomplete="new-password">
                            </div>
                            <div class="form-text text-muted small">{{ __('Minimum 8 characters. Must include lowercase, uppercase, number and special character') }}</div>
                        </div>

                        <!-- Password 2 -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonPw2"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="{{ __('Confirm password') }}" aria-label="{{ __('Confirm password') }}"
                                    aria-describedby="addonPw2" @error('password_confirmation') is-invalid @enderror required minlength="8" autocomplete="new-password">
                            </div>
                            <div class="form-text text-muted small">{{ __('Confirm password') }}</div>
                        </div>



                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0 mt-4">

                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block py-2">
                                    <span class="font-weight-bold">{{ __('Create account') }}</span>
                                </button>
                            </div>
                        </div>

                        <div class="w-100">
                            <p class="font-italic text-muted mt-3">
                                {{ __('By clicking on "Create account", you agree to the ') }} <a href="{{ $config->terms_conditions_page ?? '#' }}" class="text-muted">
                                    <u>{{ __('terms and conditions') }}</u></a>
                            </p>

                            <!-- Divider Text -->
                            <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                                <div class="border-bottom w-100 ml-5"></div>
                                <span class="px-2 small text-muted font-weight-bold text-muted">{{ __('OR') }}</span>
                                <div class="border-bottom w-100 mr-5"></div>
                            </div>


                            <!-- Already Registered -->
                            <div class="text-center w-100">
                                <p class="text-muted fw-bold">{{ __('Already registerd?') }} <a href="{{ route('login') }}" class="text-primary ml-2">{{ __('Login into your account') }}</a></p>
                            </div>

                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>


    <script>
        $(document).ready(function() {
            $('#registerForm').submit(function() {
                $this = $(this);
                /** prevent double posting */
                if ($this.data().isSubmitted) {
                    return false;
                }
                /** mark the form as processed, so we will not process it again */
                $this.data().isSubmitted = true;
                return true;
            });            

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

</body>


</html>
