@extends('layouts.full')
@push('page_body_class')
hold-transition login-page
@endpush

@section('content')
<div class="login-box">
    <div class="login-logo">
        @include('auth.common_logo')
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You are only one step a way from your password, create your password now.</p>

            <form action="{{ route('password.set') }}" method="POST" id="setPasswordForm">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="input-group d-block mb-3">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append custom-input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group d-block mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                    <div class="input-group-append custom-input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Set Password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route("login") }}">@lang('auth.email.button.login_back')</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
    @include('layouts.lang')
</div>
@endsection
@include('layouts.inject_script')
<script>
    $(document).ready(function() {
        $.validator.addMethod("regex",function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Format invalide");

        $("#setPasswordForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: "Email must be a valid email address."
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 8 characters.",
                    regex: "password must Contain at least one uppercase/lowercase letters, one number and one special char."
                },
                password_confirmation: {
                    required:  "Confirm password is required.",
                    minlength: "Password must be at least 8 characters.",
                    equalTo: "Password and confirm password should same."
                },
            }
        });
    });
</script>
