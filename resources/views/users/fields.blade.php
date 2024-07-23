<style>
    .select2-selection,
    .select2-selection--multiple {
        padding: 0 0 5px 0 !important;
    }
</style>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:', ['class' => 'required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:', ['class' => 'required readonly']) !!}
    {!! Form::text('email', null, ['class' => 'form-control', $pageType == 'Edit' ? 'readOnly' : '']) !!}
</div>
<?php
unset($roles[1]);
?>
<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:', ['class' => 'required']) !!}
    <div class="select2-blue">
        {!! Form::select('role_data', ['' => 'Select Role'] + $roles->toArray(), null, ['class' => 'form-control', 'multiple' => false]) !!}
    </div>
</div>
@if (!isset($user))
    <!-- Password Field -->
    {{--  <div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:',['class' => 'required']) !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>  --}}
@endif
@if (isset($user))
    <!-- Status Field -->

    <div class="form-group col-sm-6">
        {!! Form::label('status', 'Status:') !!}
        {!! Form::select('status', ['' => 'Select', 'ACTIVE' => 'Active', 'INACTIVE' => 'In-Active'], null, [
            'class' => 'form-control custom-select',
        ]) !!}
    </div>
@endif
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $('#email').keyup(function() {
            $(this).val($(this).val().toLowerCase());
        });
    </script>
@endpush
