@if(!$check_supper_admin)
{!! Form::open(['route' => ['users.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('users.show')
    <a href="{{ route('users.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    @endcan

    @can('users.edit')
    <a href="{{ route('users.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan

    @can('users.destroy')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
@endif