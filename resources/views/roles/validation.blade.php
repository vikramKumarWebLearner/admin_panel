@include('layouts.inject_script')

<script type="text/javascript">
    $(document).ready(function() {
        console.log("roles !!!")

        $('#roleForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#roleEditForm').on('keyup keypress', function(e) {
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

        $("#roleForm").validate({
            rules: {
                name: {
                    lettersOnly: true,
                    required: true,
                    maxlength:50
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                }
            }
        });

        $("#roleEditForm").validate({
            rules: {
                name: {
                    lettersOnly: true,
                    required: true,
                    maxlength:50
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                }
            }
        });

        $('.permission .check-all').click(function() {
            var check = this.checked;
            $(this).parents('.nav-item').find('.check-one').prop("checked", check);
        })

        $('.permission .check-one').click(function() {
            var parentItem = $(this).parents('.nav-treeview').parents('.nav-item');
            var check = $(parentItem).find('.check-one:checked').length == $(parentItem).find('.check-one').length;
            $(parentItem).find('.check-all').prop("checked", check)
        });

        $('.permission .check-all').each(function() {
            var parentItem = $(this).parents('.nav-item');
            var check = $(parentItem).find('.check-one:checked').length == $(parentItem).find('.check-one').length;
            $(parentItem).find('.check-all').prop("checked", check)
        })

        $('body').on('change', '.check-next-permission', function() {
            var getKeyName = $(this).data("key");
            var getName = $(this).data("name");

            var parentData = $(this).parents(".nav-treeview");
            var isIndex = $(parentData).find(`input[data-name='`+getKeyName+`.index']`)
            var isShow = $(parentData).find(`input[data-name='`+getKeyName+`.show']`)
            var isStore = $(parentData).find(`input[data-name='`+getKeyName+`.store']`)
            var isUpdate = $(parentData).find(`input[data-name='`+getKeyName+`.update']`)

            if($(this).is(':checked')){
                if(getName == getKeyName+".create"){
                    $(isStore).prop('checked', true)
                    $(isShow).prop('checked', true)
                    $(isIndex).prop('checked', true)
                }else if(getName == getKeyName+".edit"){
                    $(isUpdate).prop('checked', true)
                    $(isShow).prop('checked', true)
                    $(isIndex).prop('checked', true)
                }else if(getName == getKeyName+".destroy"){
                    $(isShow).prop('checked', true)
                    $(isIndex).prop('checked', true)
                }else if(getName == getKeyName+".send-reset-password-link"){
                    $(isShow).prop('checked', true)
                    $(isIndex).prop('checked', true)
                }else if(getName == getKeyName+".index"){
                    $(isShow).prop('checked', true)
                }
            }else{
                if(getName == getKeyName+".create"){
                    $(isStore).prop('checked', false)
                    //$(isShow).prop('checked', false)
                }else if(getName == getKeyName+".edit"){
                    $(isUpdate).prop('checked', false)
                    //$(isShow).prop('checked', false)
                }else if(getName == getKeyName+".index"){
                    $(isShow).prop('checked', false)
                }
            }
        })
    });

    function setDynamicData(IsCheckVariable,setVariable,value){
        var checkStoreCheckOrNot = $(IsCheckVariable).prop('checked');
        if(checkStoreCheckOrNot){
            $(setVariable).attr('checked', value)
        }
    }
</script>
