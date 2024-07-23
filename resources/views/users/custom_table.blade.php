@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<style>
    .date-time-column {
        white-space: nowrap;
    }
    .action-column {
        white-space: nowrap;
    }
    .action-column a {
        margin-right: 2px;
        display: inline-block;
    }
</style>

<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Role Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Resend Link</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

@push('third_party_scripts')
    @include('layouts.datatables_js')
@endpush

<script>
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: {{ config('GENERAL.STATE_SAVE') }},
            order: false,
            ajax: {
                url: "{{ route('users.index') }}",
                data: function(d) {
                    d.status = $('#status').val(),
                    d.role_id = $('#role_id').val(),
                    d.search = $('input[type="search"]').val();
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
                    data: 'name',
                    orderable: true,
                    'render': function(data, type, full, meta) {
                        return '<a class="custom-word-break" href="users/' + full.id + '" >' + full.name + '</a>';
                    }
                },
                {
                    className: 'date-time-column',
                    data: 'role_name'
                },
                {
                    className: 'custom-word-break',
                    orderable: true,
                    data: 'email'
                },
                {
                    className: 'text-center',
                    data: 'status',
                    render: function(data, type, full, meta) {
                        if (type === 'display') {
                            if (data === 'ACTIVE') {
                                return '<span class="badge badge-primary">Active</span>';
                            } else {
                                return '<span class="badge badge-danger">Inactive</span>';
                            }
                        }
                        return data;
                    }
                },
                {
                    className: 'text-center',
                    orderable: false,
                    width: '5%',
                    'render': function(data, type, full, meta) {
                        var send_reset_password_button = '';

                        @can('users.send-reset-password-link')
                        if(full.status != 'ACTIVE'){
                            send_reset_password_button = '<a onclick="sendResetPasswordLink(' + full.id +
                            ')" href="javascript:void(0);" title="Resend Set Password Mail"><i class="fa fa-envelope text-success" aria-hidden="true"></i></a>';
                        }
                        @endcan

                        return send_reset_password_button;
                    }
                },
                {
                    className: 'action-column text-center',
                    orderable: false,
                    'render': function(data, type, full, meta) {
                        var show_button = '';
                        var delete_button = '';
                        var edit_button = '';
                        @can(['users.show','users.index'])
                            show_button = '<a href="users/' + full.id + '" ><i class="fa fa-eye"></i></a>';
                        @endcan
                        @can(['users.edit','users.update'])
                            edit_button = '<a href="users/' + full.id + '/edit" class="pl-2"><i class="fa fa-edit text-warning"></i></a>';
                        @endcan
                        @can('users.destroy')
                            delete_button = '<a onclick="deleteUser(' + full.id +
                                ')" href="javascript:void(0);" title="Delete User" class="pl-2"><i class="fa fa-trash text-danger"></i></a>';
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
                $('input[type="search"]').attr('placeholder', 'Name & Email');
                $('input[type="search"]').css('width', '200px');
            }
        });

        $('#status').change(function() {
            table.draw();
        });

        $('#role_id').change(function() {
            table.draw();
        });
    });
    function deleteUser(userId) {

        Swal.fire({
            title: 'Are you sure you want to delete this user?',
            text: 'You will not be able to revert this!',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('users.destroy', ":id") }}";
                url = url.replace(':id', userId);
                $.ajax({
                    url: url,
                    type: 'delete',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'User deleted successfully.',
                            'success'
                        );
                        $('.data-table').DataTable().ajax.reload();
                        $("#error-msg").html(`<div class="alert alert-success" role="alert">
                            User deleted successfully.
                        </div>`);
                        setTimeout(function (){
                            $("#error-msg").text("");
                        },3000);
                    }
                });
            }
        });
    }

    function sendResetPasswordLink(userId) {

        Swal.fire({
            title: 'Are you sure you want to send resend link?',
            text: 'You will not be able to revert this!',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('users.set-password') }}",
                    type: 'POST',
                    data: { userId: userId },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                            'Sent!',
                            'mail sent successfully.',
                            'success'
                        );
                    }
                });
            }
        });
    }
</script>
