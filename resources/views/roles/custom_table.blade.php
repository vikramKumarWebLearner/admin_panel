@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<style>
    .action-column {
        white-space: nowrap;
    }

    .action-column a {
        margin-right: 2px;
        display: inline-block;
    }
</style>

<div class="table-responsive">
    <table class="table table-bordered data-table" id="yourDataTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

@push('third_party_scripts')
    @include('layouts.datatables_js')
@endpush

<script>
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            stateSave: {{ config('GENERAL.STATE_SAVE') }},
            ajax: {
                url: "{{ route('roles.index') }}",
                data: function(d) {
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    className: 'custom-word-break',
                    orderable: true,
                    data: 'name'
                },
                {
                    className: 'action-column',
                    orderable: false,
                    'render': function(data, type, full, meta) {
                        var show_button = '';
                        var delete_button = '';
                        var edit_button = '';
                        @can(['roles.show','roles.index'])
                            show_button = '<a href="roles/' + full.id + '" ><i class="fa fa-eye"></i></a>';
                        @endcan
                        @can(['roles.edit','roles.update'])
                            edit_button = '<a href="roles/' + full.id + '/edit" class="pl-2"><i class="fa fa-edit text-warning"></i></a>';
                        @endcan
                        @can('roles.destroy')
                            if(full.role_count == 0){
                                delete_button = '<a onclick="deleteRole(' + full.id +
                                ')" href="javascript:void(0);" title="Delete Role" class="pl-2"><i class="fa fa-trash text-danger"></i></a>';
                            }
                        @endcan
                        if(full.id != 1){
                            return show_button+edit_button+delete_button;
                        }else{
                            return '';
                        }
                    }
                }
            ],
            initComplete: function () {
                $('input[type="search"]').attr('placeholder', 'Name');
                $('input[type="search"]').css('width', '200px');
            }
        });
    });

    function deleteRole(roleId) {
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
                var url = "{{ route('roles.destroy', ":id") }}";
                url = url.replace(':id', roleId);
                $.ajax({
                    url: url,
                    type: 'delete',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.data-table').DataTable().ajax.reload();
                        $("#error-msg").html(`<div class="alert alert-success" role="alert">Role deleted successfully.</div>`);
                        setTimeout(function (){
                            $("#error-msg").text("");
                        },3000);
                    }
                });
            }
        });
    }
</script>
