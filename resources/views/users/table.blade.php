@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('third_party_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
@include('layouts.inject_script')
<script>
    $(document).ready(function() {
        // Set the CSRF token for Ajax requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // Function to send reset password link via Ajax
    function sendResetPasswordLink(userId) {
        $.ajax({
            url: "{{ route('users.send-reset-password-link') }}",
            type: 'POST',
            data: { userId: userId },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>