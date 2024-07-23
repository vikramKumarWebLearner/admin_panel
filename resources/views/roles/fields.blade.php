@push('page_css')
<style>
    .permission {
        max-height: 400px;
        height: 100%;
        overflow: auto;
    }

    .permission .nav .nav-treeview {
        margin-left: 20px;
    }

    .permission .nav-sidebar .nav-item {
        position: relative;
    }

    .permission .nav-sidebar .nav-item .check-all {
        margin: .7rem 0rem;
    }

    .permission .nav-sidebar .nav-item .nav-link {
        padding: 0.5rem 0.5rem;
    }

    .permission .nav-sidebar .nav-item .nav-link p {
        width: unset;
        visibility: unset;
        margin-left: 0;
        -webkit-animation-name: unset;
        animation-name: unset;
        -webkit-animation-duration: unset;
        animation-duration: unset;
        -webkit-animation-fill-mode: unset;
        animation-fill-mode: unset;
    }

    .permission .nav-sidebar .menu-open .nav-link i.right {
        -webkit-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }
</style>
@endpush

<div class="col-sm-12 col-lg-4">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Name',['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Title Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Guard Name Field -->
        <div class="form-group col-sm-12" style="display:none;">
            {!! Form::label('guard_name', 'Guard Name') !!}
            {!! Form::select('guard_name', ['web' => 'web', 'api' => 'api'], $pageType == "Add" ? 'web' : null, ['class' => 'form-control custom-select']) !!}
        </div>


        <!-- Description Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control','rows'=>5]) !!}
        </div>
    </div>


</div>

<!-- Permission Field -->
<div class="form-group col-sm-12 col-lg-8 ">
    @php
    $groupPermission = $allPermission->groupBy('module');
    @endphp
    <div class="permission">
        {!! Form::label('permission', 'Permission') !!}
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @foreach ( $groupPermission as $key=>$permissions)

            <li class="nav-item">
                <div class="d-flex">
                    {!! Form::checkbox('checkAll', null,false, ['class' => 'check-all']) !!}
                    <a href="#" class="nav-link flex-fill">
                        <i class="nav-icon fas fa-shield-virus"></i>
                        <p>
                            {{fast_trans('common.module.'.$key,[],$key)}}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                </div>

                <ul class="nav nav-treeview">
                    @foreach ($permissions as $permission)
                    <li class="nav-item" data-name = {{$permission->name}}>
                        <a class="nav-link" {{($permission->name == $key.".store" || $permission->name == $key.".update" || $permission->name == $key.".show") ? "hidden" : ""}}>
                            {!! Form::checkbox('permission_data[]', $permission->id,(isset($role)&&count($role->permission_data)>0&&isset($role->permission_data[$permission->id])?true:false), ['class' => 'check-one check-next-permission','data-name' => $permission->name,'data-key' => $key, "hidden" => $permission->name == "permissions.store" ? true : false]) !!}
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                {{fast_trans('common.permission.'.$permission->name,[],$permission->title)}}
                            </p>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </li>
            @endforeach

        </ul>
    </div>
</div>
