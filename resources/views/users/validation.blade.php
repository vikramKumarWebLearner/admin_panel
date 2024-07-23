@include('layouts.inject_script')

<script type="text/javascript">
    $(document).ready(function() {
        console.log("users !!!")

        $('#userForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#userEditForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        // Custom rule for alphabets only
        $.validator.addMethod("lettersOnly", function(value, element) {
            // Check if the value contains only whitespace characters
            if (/^\s+$/.test(value)) {
                return false;
            }
            // Check if the value contains only alphabetic characters and spaces
            return /^[A-Za-z\s]+$/.test(value);
        }, "Please enter only alphabetic characters");

        $("#userForm").validate({
            rules: {
                name: {
                    lettersOnly: true,
                    required: true,
                    maxlength:100
                },
                email: {
                    required: true,
                    email: true
                },
                role_data: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Name is required."
                },
                email: {
                    required: "Email is required.",
                    email: "Email must be a valid email address."
                },
                role_data: {
                    required: "Role is required."
                }
            }
        });

        $("#userEditForm").validate({
            rules: {
                name: {
                    lettersOnly: true,
                    required: true,
                    maxlength:100
                },
                email: {
                    required: true,
                    email: true
                },
                role_data: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Name is required."
                },
                email: {
                    required: "Email is required.",
                    email: "Email must be a valid email address."
                },
                role_data: {
                    required: "Role is required."
                }
            }
        });

    });
</script>
