@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>

                @can('users.create')
                    <div class="col-sm-6">
                        <a class="btn btn-primary float-right" href="{{ route('users.create') }}">Add New</a>
                    </div>
                @endcan
            </div>
        </div>
    </section>
    <div class="content px-3">
        <div class="alert-container">
            @include('custom_flash_message')
        </div>
        <div id="error-msg"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                <div class="row mb-2 m-2">
                    <div class="col-sm-3">
                        {!! Form::select('status', ['' => 'Select Status', 'ACTIVE' => 'Active', 'INACTIVE' => 'Inactive'], null, [
                            'class' => 'form-control',
                            'id' => 'status',
                            'multiple' => false,
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('role_data', array_merge(['' => 'Select Role'], $roles->toArray()), null, [
                            'class' => 'form-control',
                            'id' => 'role_id',
                            'multiple' => false,
                        ]) !!}
                    </div>
                </div>
                @include('users.custom_table')
                {{-- @include('users.table') --}}
                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.inject_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function sendResetPasswordLink(userId) {
        $.ajax({
            url: "{{ route('users.send-reset-password-link') }}",
            type: 'POST',
            data: {
                userId: userId
            },
            success: function(response) {
                alert(response.message);
            }
        });
    }
</script>
