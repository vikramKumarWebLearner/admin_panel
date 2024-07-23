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
            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

            <form action="{{ route('password.update') }}" method="POST" id="resetPasswordForm">
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
                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">@lang('auth.email.button.login_back')</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
    @include('layouts.lang')
</div>
@endsection
@include('auth.passwords.validation');
