@if (Auth::user())
    @if (Auth::user()->profile_image)
        <img src="{{asset('profile_images/'.Auth::user()->profile_image )}}" class="user-image img-circle elevation-2" alt="User Image">
    @else
        <img src="{{asset('images/user_logo.jpeg')}}" class="user-image img-circle elevation-2" alt="User Image">
    @endif
@else
    <img src="{{asset('images/user_logo.jpeg')}}" class="user-image img-circle elevation-2" alt="User Image">
@endif
{{-- <img src="{{asset('images/user_logo.jpeg')}}" class="user-image img-circle elevation-2" alt="User Image"> --}}
