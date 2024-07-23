@if(!$check_supper_admin)
{!! Form::open(['route' => ['roles.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @can('roles.show')
    <abbr title="View">
        <a href="{{ route('roles.show', $id) }}" class='btn btn-default btn-xs'>
            <i class="fa fa-eye"></i>
        </a>
    </abbr>
    &nbsp
    @endcan

    @can('roles.edit')
    <abbr title="Edit">
        <a href="{{ route('roles.edit', $id) }}" class='btn btn-default btn-xs'>
            <i class="fa fa-edit"></i>
        </a>
    </abbr>
    &nbsp
    @endcan

    @can('roles.edit')
    {!! Form::button('<abbr title="Delete"><i class="fa fa-trash"></i></abbr>', [
    'type' => 'submit',
    'class' => 'btn btn-danger btn-xs',
    'onclick' => "return confirm('Are you sure you want to delete this role?')"
    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
@endif
