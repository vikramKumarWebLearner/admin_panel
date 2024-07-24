@extends('layouts.app')
@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                @can('categories.create')
                    <div class="col-sm-6">
                        <a class="btn btn-primary float-right" href="{{ route('categories.create') }}">Add Category</a>
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
                <table class="table table-bordered data-table" id="categories">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <div class="card-footer clearfix">
                    <div class="float-right"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inject_script')
@push('third_party_scripts')
    @include('layouts.datatables_js')
@endpush
<script>
    function deleteCategory(roleId) {
        Swal.fire({
            title: 'Are you sure you want to delete this role?',
            text: 'You will not be able to revert this!',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('categories.destroy', ':id') }}";
                url = url.replace(':id', categoryId);
                $.ajax({
                    url: url,
                    type: 'delete',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.data-table').DataTable().ajax.reload();
                    }
                });
            }
        });
    }
    $(document).ready(function() {
        var datatables = $('#categories').DataTable({
            responsive: true,
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side processing
            ajax: {
                url: "{{ route('categories.getData') }}", // URL to your API endpoint
                type: 'GET' // HTTP method to use for the request
            },
            columns: [{
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'slug',
                    name: 'slug',
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    className: 'action-column',
                    orderable: false,
                    'render': function(data, type, full, meta) {
                        var show_button = '';
                        var delete_button = '';
                        var edit_button = '';
                        @can(['categories.show', 'categories.index'])
                            show_button = '<a href="categories/' + full.id +
                                '" ><i class="fa fa-eye"></i></a>';
                        @endcan
                        @can(['categories.edit', 'categories.update'])
                            edit_button = '<a href="categories/' + full.id +
                                '/edit" class="pl-2"><i class="fa fa-edit text-warning"></i></a>';
                        @endcan
                        @can('categories.destroy')
                            delete_button = '<a onclick="deleteCategory(' + full.id +
                                ')" href="javascript:void(0);" title="Delete Role" class="pl-2"><i class="fa fa-trash text-danger"></i></a>';
                        @endcan
                        return show_button + edit_button + delete_button;
                    }
                }
            ]
        })
    });
</script>
