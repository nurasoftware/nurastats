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

    <link href="{{ asset('/assets//vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}" />
    <script src="{{ asset('/assets/vendor/select2/select2.min.js') }}"></script>
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
                    <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="{{ config('app.name') }}">
                    <hr>
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


                <div class='fs-6 mb-2'>{{ __('Creează contul tău pe Ropo.ro. Durează doar un minut.') }}</div>

                <form method="POST" action="{{ route('register') }}" autocomplete="off" id="registerForm">
                    @csrf

                    <div class="row">

                        <!-- Name -->
                        <div class="col-12 mb-3">
                            <label class="fw-bold mb-1">{{ __('Numele tău complet') }}</label>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonName"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="{{ __('Your name') }}" aria-label="{{ __('Ypur name') }}" aria-describedby="addonName"
                                    @error('name') is-invalid @enderror require value="{{ old('name') }}">
                            </div>
                            <div class="form-text text-muted small">{{ __('Numele tău complet') }}</div>
                        </div>

                        <!-- Email -->
                        <div class="col-12 mb-3">
                            <label class="fw-bold mb-1">{{ __('Creează adresa mea personală de email') }}</label>
                            <div class="input-group mb-1">
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="{{ __('Username') }}" aria-label="{{ __('Username') }}" aria-describedby="addonEmail"
                                    minlength="8" maxlength="50" @error('email') is-invalid @enderror required autocomplete="off" value="{{ old('username') }}">
                                <span class="input-group-text" id="addonEmailDomain">@ropo.ro</span>
                            </div>
                            <div class="form-text text-muted small">{{ __("Doar litere, cifre, . (punct) și _ (subliniere). Nu puteți schimba adresa de e-mail după înregistrare.") }}</div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonPw"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="{{ __('Parola') }}" aria-label="{{ __('Parola') }}" aria-describedby="addonPw"
                                    @error('password') is-invalid @enderror required minlength="8" autocomplete="new-password">
                            </div>
                            <div class="form-text text-muted small">{{ __('Introdu o parola puternică') }}</div>
                        </div>

                        <!-- Password 2 -->
                        <div class="col-md-6 col-12 mb-3">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="addonPw2"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="{{ __('Confirmare parolă') }}" aria-label="{{ __('Confirmare parolă') }}"
                                    aria-describedby="addonPw2" @error('password_confirmation') is-invalid @enderror required minlength="8" autocomplete="new-password">
                            </div>
                            <div class="form-text text-muted small">{{ __('Confirmare parolă') }}</div>
                        </div>




                        <div class="row">
                            <div class='col-12'>
                                <label class="fw-bold mb-1">{{ __('Data nașterii') }}</label>
                                <div class="text-muted small mb-2">
                                    {{ __('IMPORTANT: Introduceți ziua de naștere reală pentru că nu o puteți schimba mai târziu. Dacă ați uitat parola, trebuie să introduceți ziua de naștere pentru a vă recupera parola.') }}
                                </div>
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <select class="form-select" name="birthday_day" required>
                                    <option value="">-- {{ __('Ziua') }} --</option>
                                    @for ($day = 1; $day <= 31; $day++)
                                        <option @if (old('birthday_day') == $day) selected @endif value="{{ $day }}">{{ $day }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-4 col-12 mb-3">
                                <select class="form-select" name="birthday_month" required>
                                    <option value="">-- {{ __('Luna') }} --</option>
                                    <option @if (old('birthday_month') == '01') selected @endif value="01">{{ __('Ianuarie') }}</option>
                                    <option @if (old('birthday_month') == '02') selected @endif value="02">{{ __('Februarie') }}</option>
                                    <option @if (old('birthday_month') == '03') selected @endif value="03">{{ __('Martie') }}</option>
                                    <option @if (old('birthday_month') == '04') selected @endif value="04">{{ __('Aprilie') }}</option>
                                    <option @if (old('birthday_month') == '05') selected @endif value="05">{{ __('Mai') }}</option>
                                    <option @if (old('birthday_month') == '06') selected @endif value="06">{{ __('Iunie') }}</option>
                                    <option @if (old('birthday_month') == '07') selected @endif value="07">{{ __('Iulie') }}</option>
                                    <option @if (old('birthday_month') == '08') selected @endif value="08">{{ __('August') }}</option>
                                    <option @if (old('birthday_month') == '09') selected @endif value="09">{{ __('Septembrie') }}</option>
                                    <option @if (old('birthday_month') == '10') selected @endif value="10">{{ __('Octombrie') }}</option>
                                    <option @if (old('birthday_month') == '11') selected @endif value="11">{{ __('Noiembrie') }}</option>
                                    <option @if (old('birthday_month') == '12') selected @endif value="12">{{ __('Decembrie') }}</option>
                                </select>
                            </div>

                            <div class="col-md-5 col-12 mb-3">
                                <select class="form-select" name="birthday_year" required>
                                    <option value="">-- {{ __('An') }} --</option>
                                    @for ($year = date('Y') - 12; $year >= 1940; $year--)
                                        <option @if (old('birthday_year') == $year) selected @endif value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-12">
                                <label class="fw-bold mb-1">{{ __('Sex') }}</label>
                                <select class="form-select" name="sex" required>
                                    <option value="">-- {{ __('Alege') }} --</option>
                                    <option @if (old('sex') == 'm') selected @endif value="m">{{ __('Masculin') }}</option>
                                    <option @if (old('sex') == 'f') selected @endif value="f">{{ __('Feminin') }}</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12">
                                <label class="fw-bold mb-1">{{ __('Județul unde locuiesc') }}</label>
                                <select class="form-select select2 w-100" name="loc_county_id" id="county" required>
                                    <option value="">-- {{ __('Alege') }} --</option>
                                    @foreach ($loc_counties as $loc_county)
                                        <option value="{{ $loc_county->id }}">{{ $loc_county->name }}</option>
                                    @endforeach
                                    <option value="">- {{ __('Locuiesc în afara României') }} -</option>
                                </select>
                            </div>

                            <div class="col-md-5 col-12">
                                <label class="fw-bold mb-1">{{ __('Orașul unde locuiesc') }}</label>
                                <select class="form-select select2 w-100" name="loc_city_id" id="city">
                                    <option value="">-- {{ __('Selectează județul') }} --</option>
                                </select>
                            </div>

                            <div class='col-12'>
                                <div class="text-muted small mt-2 mb-3">{{ __('IMPORTANT: Introduceți sexul și locația dvs. reală, pentru a vă afișa cel mai relevant conținut (știri și articole locale).') }}
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input type='hidden' value='' name='pw_recover'>
                                <input class="form-check-input" type="checkbox" id="pw_recover" name="pw_recover" @if ((old('pw_recover') ?? null) == 'on') checked @endif>
                                <label class="form-check-label fw-bold" for="pw_recover">{{ __('Creați un cod de recuperare a parolei') }}</label>
                            </div>
                            <div class="form-text text-danger small fw-bold"><i class="bi bi-exclamation-triangle"></i>
                                {{ __("Este recomandat să creați un cod de recuperare. Dacă ați uitat parola, nu vă puteți accesa contul Ropo dacă nu aveți un cod de recuperare") }}
                            </div>
                        </div>

                        <script>
                            $('#pw_recover').change(function() {
                                select = $(this).prop('checked');
                                if (select)
                                    document.getElementById('hidden_div_pw_recover').style.display = 'block';
                                else
                                    document.getElementById('hidden_div_pw_recover').style.display = 'none';
                            })
                        </script>

                        <div id="hidden_div_pw_recover" style="display: @if ((old('pw_recover') ?? null) == 'on') block @else none @endif">
                            <div class="form-group col-12 mt-3 mb-3">
                                <label>{{ __('Cod de recuperare a parolei') }}</label>
                                <input class="form-control" name="pw_recovery_code" type="text" value="{{ old('pw_recovery_code') ?? ($recoveryCode ?? null) }}" readonly>
                            </div>

                            <a class="btn btn-success" href="{{ route('register.download-pw-recovery-code', ['code' => old('pw_recovery_code') ?? ($recoveryCode ?? null)]) }}"><i class="bi bi-download"></i>
                                {{ __('Descărcați codul de recuperare') }}</a>
                            <div class="form-text text-muted small">
                                {{ __('Păstrați fișierul cu codul de recuperare într-o locație sigură. Nu distribuiți nimănui acest fișier sau cod.') }}
                            </div>

                        </div>


                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0 mt-4">

                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block py-2">
                                    <span class="font-weight-bold">{{ __('Creează cont Ropo.ro') }}</span>
                                </button>
                            </div>
                        </div>

                        <div class="w-100">
                            <p class="font-italic text-muted mt-3">
                                {{ __('Făcând clic pe "Creează cont Ropo.ro", sunteți de acord cu ') }} <a href="{{ $config->terms_conditions_page ?? '#' }}" class="text-muted">
                                    <u>{{ __('Termenii și condițiile') }}</u></a>
                            </p>

                            <!-- Divider Text -->
                            <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                                <div class="border-bottom w-100 ml-5"></div>
                                <span class="px-2 small text-muted font-weight-bold text-muted">{{ __('SAU') }}</span>
                                <div class="border-bottom w-100 mr-5"></div>
                            </div>


                            <!-- Already Registered -->
                            <div class="text-center w-100">
                                <p class="text-muted fw-bold">{{ __('Ai deja un cont Ropo.ro?') }} <a href="{{ route('login') }}" class="text-primary ml-2">{{ __('Intră în cont') }}</a></p>
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

            $('.select2').select2({
                theme: "bootstrap-5",
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#county').on('change', function() {
                var countyID = $(this).val();
                if (countyID) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('ajax.loc_cities') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            loc_county_id: countyID,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(html) {
                            $('#city').html(html);
                        },
                        error: function() {
                            console.log('Error ' + countyID);
                        }
                    });
                } else {
                    $('#city').html('<option value="">Select county first</option>');
                }
            });
        });
    </script>

</body>


</html>
