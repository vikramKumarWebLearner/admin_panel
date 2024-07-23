<script>
    $(document).ready(updateClass);

    $(window).resize(updateClass);

    // Define a function to add or remove the class
    function updateClass() {
        // Get the window width
        var width = $(window).width();
        console.log(width)
        // Check if the width is less than or equal to 720px
        if (width <= 1024) {
            // Select the table element by its id
            var table = $(".table");

            // Add the class "table" to the table element
            table.addClass("table-responsive");
        } else {
            // Select the table element by its id
            var table = $(".table");

            // Remove the class "table" from the table element
            table.removeClass("table-responsive");
        }
    }
</script>
