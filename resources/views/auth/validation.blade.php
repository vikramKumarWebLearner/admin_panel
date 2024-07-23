@include('layouts.inject_script')

<script type="text/javascript">
    $(document).ready(function() {
        console.log("loginForm !!!")

        $('#loginForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: "Email must be a valid email address."
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 8 characters."
                }
            }
        });

    });
</script>
