<div class="row col-sm-12">
@php
$roleArray = array();
$roleData = $user->roles->toArray();
foreach($roleData as $value){
    array_push($roleArray,$value['name']);
}    

$role = implode(",",$roleArray);
@endphp
    <div class="column col-sm-6">
        <!-- Name Field -->
        <div class="col-sm-12">
            {!! Form::label('name', 'Name:') !!}
            <p>{{ $user->name }}</p>
        </div>

        <!-- Role Field -->
        <div class="col-sm-12">
            {!! Form::label('role', 'Role:') !!}
            <p>{{ $role }}</p>
        </div>
    </div>
    <div class="column col-sm-6">
        <!-- Email Field -->
        <div class="col-sm-12">
            {!! Form::label('email', 'Email:') !!}
            <p>{{ $user->email }}</p>
        </div>

        <!-- Status Field -->
        <div class="col-sm-12">
            {!! Form::label('status', 'Status:') !!}
            <p>{{ $user->status ? 'Active' : 'In-active' }}</p>
        </div>
    </div>
</div>