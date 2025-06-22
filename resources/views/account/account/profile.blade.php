<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('My account') }}</li>
                </ol>
            </nav>
        </div>
    </div>
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

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        @if ($message == 'updated')
            {{ __('Updated') }}
        @endif
        @if ($message == 'avatar-deleted')
            {{ __('Deleted') }}
        @endif
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        @if ($message == 'duplicate')
            {{ __('Error. You can not use this email.') }}
        @endif

        @if ($message == 'all_pw_required')
            {{ __('Error. All password fields are required.') }}
        @endif
        @if ($message == 'wrong_current_password')
            {{ __('Error. Current password do not match.') }}
        @endif
    </div>
@endif

<div class="card">

    <div class="card-body">


        <div class="row">

            <div class="col-12">

                <div class="fw-bold mb-3 fs-5">{{ Auth::user()->name }}</div>


                <form method="post" id="profileForm">
                    @csrf

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <label>{{ __('Email') }}</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="addon-mail"><i class="bi bi-envelope"></i></span>
                                <input class="form-control form-control-lg" type="email" name="email" value="{{ Auth::user()->email }}" required placeholder="email" aria-label="email"
                                    aria-describedby="addon-email" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <label>{{ __('Full name') }}</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="addon-name"><i class="bi bi-person-workspace"></i></span>
                                <input class="form-control form-control-lg" type="text" name="name" value="{{ Auth::user()->name }}" required placeholder="name" aria-label="name" aria-describedby="addon-name" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 mt-3">
                        <div class="form-check form-switch mt-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="exclude_my_visits" @if (($exclude_my_visits ?? null) == 1) checked @endif>
                            <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('Exclude my visits from analytics') }}</label>
                        </div>
                        <div class="text-muted small">{{ __('Exclude my visits from this browser using a cookie. A "nurastats_ignore" cookie without expiry date is created.') }}</div>
                    </div>

                    <input type="hidden" name="section" value="profile">
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Update profile') }}</button>

                </form>
            </div>

        </div>

    </div>

</div>
<!-- end card-body -->


<div class="card">

    <div class="card-body">

        <div class="fw-bold mb-2 fs-5">{{ __('Account security') }}</div>

        <i class="bi bi-info-circle"></i>
        @if ($last_pw_change_at)
            {{ __('The password was last changed on ') }} {{ date_locale($last_pw_change_at, 'd M Y, H:i') }}
        @else
            <span class="text-dagner">{{ __('The password was never changed') }}</span>
        @endif

        <div class="clearfix"></div>

        <a href="#" data-bs-toggle="modal" data-bs-target=".password" class="btn btn-primary mt-3">{{ __('Change password') }}</a>
        <div class="modal fade password modal-lg" tabindex="-1" role="dialog" aria-labelledby="PasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="PasswordLabel">{{ __('Change password') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{ __('Input current password') }}</label>
                                        <input autocomplete="false" class="form-control" name="current_password" type="password" value="" autocomplete="current-password"
                                            @error('current_password') is-invalid @enderror minlength="8" id="currentPwInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="{{ __('Minimum 8 characters. At least one number and one uppercase and lowercase letter') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{ __('Input new password') }}</label>
                                        <input autocomplete="false" class="form-control" name="password" type="password" value="" autocomplete="new-password" @error('password') is-invalid @enderror
                                            minlength="8" id="pwInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="{{ __('Minimum 8 characters. At least one number and one uppercase and lowercase letter') }}" />
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{ __('Confirm new password') }}</label>
                                        <input autocomplete="false" class="form-control" name="password_confirmation" type="password" value="" autocomplete="new-password-confirm"
                                            @error('password_confirm') is-invalid @enderror minlength="8" id="confirmPwInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                            title="{{ __('Minimum 8 characters. At least one number and one uppercase and lowercase letter') }}" />
                                    </div>
                                </div>
                            </div>

                            <div id="pwShowDiv" style="display:block">
                                <div class="form-check mt-2">
                                    <input type="checkbox" onclick="showPassword()" class="form-check-input mt-1" id="showPw"> <label for="showPw" class="fw-normal">{{ __('Show Password') }}</label>
                                </div>
                            </div>

                            <div class="text-muted small">{{ __('Password must have minimum 8 characters, at least one number and one uppercase and lowercase letter') }}</div>


                            <script>
                                function showPassword() {
                                    var x = document.getElementById("currentPwInput");
                                    var y = document.getElementById("pwInput");
                                    var z = document.getElementById("confirmPwInput");
                                    if (x.type === "password") {
                                        x.type = "text";
                                        y.type = "text";
                                        z.type = "text";
                                    } else {
                                        x.type = "password";
                                        y.type = "password";
                                        z.type = "password";
                                    }
                                }
                            </script>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Change password') }}</button>
                        </div>

                        <input type="hidden" name="section" value="pw">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $('#profileForm').submit(function() {
            $this = $(this);
            /** prevent double posting */
            if ($this.data().isSubmitted) {
                return false;
            }
            /** mark the form as processed, so we will not process it again */
            $this.data().isSubmitted = true;
            return true;
        });
    });
</script>
