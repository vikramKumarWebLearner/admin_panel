@extends('layouts.app')
<style>
    .profile-username {
        margin: 0 0 0 0;
    }
    body {
    background-color: #efefef;
    }

    .profile-pic {
        max-width: 200px;
        max-height: 200px;
        display: block;
    }

    .file-upload {
        display: none;
    }
    .circle {
        /* margin-left: 10%; */
        display: block;
        margin: 0 auto;
        border-radius: 1000px !important;
        overflow: hidden;
        width: 150px;
        height: 150px;
        /* border: 8px solid rgba(255, 255, 255, 0.7); */
        /* position: absolute; */
        top: 72px;
    }
    img {
        max-width: 100%;
        height: auto;
    }
    .p-image {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #666666;
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }
    .p-image:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }
    .upload-button {
        font-size: 1.5em;
    }

    .upload-button:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        color: #999;
    }

    #profile-pic{
        height: 100%;
        width: 100%;
    }

</style>

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{--  <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>  --}}
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @include('users.profile.user_logo')
                             </div>

                            @php
                                $roleArray = [];
                                $roleData = $user->roles->toArray();
                                foreach ($roleData as $value) {
                                    array_push($roleArray, $value['name']);
                                }

                                $role = implode(',', $roleArray);
                            @endphp

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>
                            <p class="text-muted text-center"> {{ $role ? '(' . $role . ')' : '--' }}</p>
                            <p class="text-muted text-center">{{ $user->email }}</p>


                            {{--  <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>  --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">

                        <div class="card-header p-2">
                            @include('adminlte-templates::common.errors')
                            <div class="alert-container">
                                @include('custom_flash_message')
                            </div>
                            <ul class="nav nav-pills profile">
                                <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab"
                                        data-style="107px">Profile</a></li>
                                <li class="nav-item"><a class="nav-link change-Password" href="#change-Password"
                                        data-toggle="tab" data-style="53px">Change Password</a></li>
                            </ul>

                        </div>
                        <!-- /.card-header -->

                        <div class="card-body" id="profile-card-body" style="padding-bottom: 107px;">

                            <div class="tab-content">

                                <div class="tab-pane active" id="profile">

                                    {!! Form::model($user, [
                                        'route' => ['users.updateProfile', $user->id],
                                        'method' => 'patch',
                                        'id' => 'profileChangeForm',
                                    ]) !!}
                                    <!-- Name Field -->
                                    <div class="form-group row">
                                        {!! Form::label('name', 'Name:', ['class' => 'col-sm-2 col-form-label required']) !!}

                                        <div class="col-sm-10">
                                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    {{--  <!-- Email Field -->
                                <div class="form-group row">
                                    {!! Form::label('email', 'Email:',['class' => 'col-sm-2 col-form-label' ]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('email', null, ['class' => 'form-control','readonly']) !!}
                                    </div>
                                </div>  --}}
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Update</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="tab-pane" id="change-Password">

                                    {!! Form::model($user, [
                                        'route' => ['users.changePassword', $user->id],
                                        'method' => 'post',
                                        'id' => 'profileChangePasswordForm',
                                    ]) !!}
                                    <!-- Password Field -->
                                    <div class="form-group row">
                                        {!! Form::label('current_password', 'Current Passowrd:', ['class' => 'col-sm-3 col-form-label required']) !!}
                                        <div class="col-sm-9">
                                            {!! Form::password('current_password', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group row">
                                        {!! Form::label('password_new', 'New Passowrd:', ['class' => 'col-sm-3 col-form-label required']) !!}
                                        <div class="col-sm-9">
                                            {!! Form::password('password_new', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group row">
                                        {!! Form::label('password_new_confirmation', 'Confirm Passowrd:', [
                                            'class' => 'col-sm-3 col-form-label required',
                                        ]) !!}
                                        <div class="col-sm-9">
                                            {!! Form::password('password_new_confirmation', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="btn btn-danger">Update Password</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@include('layouts.inject_script')
<script>
    $(document).ready(function() {
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-pic').attr('src', e.target.result);
                }

                var formData = new FormData();
                formData.append('image', input.files[0]);

                $.ajax({
                    type: 'POST',
                    url: '{{ route("users.profile.image") }}', // Replace with your Laravel route
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle the success response (e.g., display uploaded image)
                        // $('#profile-pic').attr('src', response.image);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors if needed
                        console.error('Error:', error);
                    }
                });

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".file-upload").on('change', function(){
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });

        var checkHash = window.location.hash;
        if (checkHash == '#change-Password') {
            setTimeout(() => {
                var link = document.querySelectorAll('.change-Password');
                link[0].click();
            }, 100);
        }

        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Format invalide");

        $("#profileChangePasswordForm").validate({
            rules: {
                current_password: {
                    required: true,
                },
                password_new: {
                    required: true,
                    minlength: 8,
                    regex: /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
                },
                password_new_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password_new"
                },
            },
            messages: {
                current_password: {
                    required: "Current password is required.",
                },
                password_new: {
                    required: "New password is required.",
                    minlength: "New password must be at least 8 characters.",
                    regex: "New password must Contain at least one uppercase/lowercase letters, one number and one special char."
                },
                password_new_confirmation: {
                    required: "Confirm password is required.",
                    minlength: "Password must be at least 8 characters.",
                    equalTo: "Password and confirm password should same."
                },
            }
        });

        $("#profileChangeForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                    maxlength: "Maximum name length is 50 characters.",
                }
            }
        });
    });
</script>
<script>
    window.onload = function() {
        var divClass = document.querySelectorAll('.profile .nav-item');

        Array.from(divClass).forEach(link => {
            link.addEventListener('click', function(event) {
                var getDataAttr = event.target.getAttribute("data-style");
                document.getElementById("profile-card-body").style.paddingBottom = getDataAttr;
            });
        });
    }
</script>
