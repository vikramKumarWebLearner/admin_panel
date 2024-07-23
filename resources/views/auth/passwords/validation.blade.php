@include('layouts.inject_script')

<script type="text/javascript">
    $(document).ready(function() {
        console.log("auth.passwords.validation !!!")

        $('#resetForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#resetPasswordForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $.validator.addMethod("regex",function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Format invalide");

        $("#resetForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: "Email must be a valid email address."
                }
            }
        });

        $("#resetPasswordForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/,
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: "Email must be a valid email address."
                },
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 8 characters.",
                    regex: "password must Contain at least one uppercase/lowercase letters, one number and one special char."
                },
                password_confirmation: {
                    required:  "Confirm password is required.",
                    minlength: "Password must be at least 8 characters.",
                    equalTo: "Password and confirm password should same."
                },
            }
        });

    });
</script>
