{{-- <img src="{{asset('images/user_logo.jpeg')}}" class="user-image img-circle elevation-2" alt="User Image"> --}}
<div class="circle">
    @if ($user)
        @if ($user->profile_image)
            <img class="" id="profile-pic" src="{{asset('profile_images/'.$user->profile_image )}}">
        @else
            <img class="" id="profile-pic" src="{{asset('images/user_logo.jpeg')}}">
        @endif
    @else
    <img class="" id="profile-pic" src="{{asset('images/user_logo.jpeg')}}">
    @endif
</div>
<div class="p-image">
<i class="fa fa-camera upload-button"></i>
    <input class="file-upload" type="file" accept="image/*"/>
</div>
