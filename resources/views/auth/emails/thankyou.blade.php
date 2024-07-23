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
            <h4>Password Set Successfully</h4>
            <p class="login-box-msg">Thank you for setting your password. You can now log in with your new password.</p>

            <p class="mt-3 mb-1 login-box-msg">
                <a href="{{ route('login') }}">Login</a>
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