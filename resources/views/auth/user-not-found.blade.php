@extends('layouts.full')
@push('page_body_class')
hold-transition login-page
@endpush

@section('content')
<div class="login-box">
    <p class="login-box-msg">
        @lang('auth.user_not_found')

        <br/>
        <a href="{{ route("login") }}">@lang('auth.email.button.login_back')</a>
    </p>
    @include('layouts.lang')
</div>

@endsection
