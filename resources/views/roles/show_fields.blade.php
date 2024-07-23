<div class="row col-sm-12">
    <div class="column col-sm-6">
        <!-- Name Field -->
        <div class="col-sm-12">
            {!! Form::label('name', 'Name:') !!}
            <p>{{ $role->name }}</p>
        </div>

        <!-- Title Field -->
        <div class="col-sm-12">
            {!! Form::label('title', 'Title:') !!}
            <p>{{ $role->title }}</p>
        </div>

        <!-- Guard Name Field -->
        <div class="col-sm-12">
            {!! Form::label('guard_name', 'Guard Name:') !!}
            <p>{{ $role->guard_name }}</p>
        </div>
    </div>
    <div class="column col-sm-6">
        <!-- Description Field -->
        <div class="col-sm-12">
            {!! Form::label('description', 'Description:') !!}
            <p>{{ $role->description }}</p>
        </div>

        <!-- Created At Field -->
        <div class="col-sm-12">
            {!! Form::label('created_at', 'Created At:') !!}
            <p>{{ $role->created_at }}</p>
        </div>

        <!-- Updated At Field -->
        <div class="col-sm-12">
            {!! Form::label('updated_at', 'Updated At:') !!}
            <p>{{ $role->updated_at }}</p>
        </div>
    </div>
</div>