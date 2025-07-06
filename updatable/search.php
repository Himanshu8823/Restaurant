<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Himanshu's Online Food Ordering System</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/preloader.css" rel="stylesheet">
  <!-- Inside the <head> section -->
<style>
    /* Preloader styles */
    /* Updated Preloader styles for animation */
/* Updated Preloader styles for animation */
/* Updated Preloader styles for an attractive spinner */
/* Updated Preloader styles for dot animation */


    /* Rest of your styles */
    .form-control {
        font-size: 25px !important;
        color: black;
        width: 500px;
        height: 40px;
    }

    #searchInput {
        font-size: 25px !important;
        border: 2px solid black;
        width: 400px;
    }

    #searchButton {
        font-size: 25px !important;
        color: white;
        background-color: cornflowerblue;
        width: 200px;
        height: 50px;
    }
</style>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
<!-- Preloader with Stylish Background -->
<!-- Preloader with Stylish Background -->
<!-- Preloader with Dot Animation -->
<div class="preloader">
    <div class="dot-spinner">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>


    <?php include("header.php"); ?>
    <br><br><br><br><br>
    <center>
        <div class="container mt-5">
            <!-- Live Search Form -->
            <form class="form-inline" id="liveSearchForm">
                <div class="form-group">
                    <input type="text" class="form-control" name="query" id="searchInput" placeholder="Search" style="border:2px solid black;width:400px">
                    <button type="button" class="form-control" id="searchButton">Search</button>
                </div>
            </form>
            <br><br>
            <!-- Live Search Results -->
            <div id="liveSearchResults"></div>
        </div>
    </center>

    <script>
        $(document).ready(function () {
            // Load all items initially
            loadAllItems();

            // Live search on input change
            $('#searchInput').on('input', function () {
                var query = $(this).val();

                if (query === "") {
                    // If the search input is empty, load all items
                    loadAllItems();
                } else {
                    // Perform AJAX request to fetch live search results
                    $.ajax({
                        url: 'live_search.php',
                        method: 'GET',
                        data: { query: query },
                        success: function (response) {
                            $('#liveSearchResults').html(response);
                        }
                    });
                }
            });

            // Function to load all items
            function loadAllItems() {
                $.ajax({
                    url: 'live_search.php', // Assuming live_search.php handles loading all items
                    method: 'GET',
                    success: function (response) {
                        $('#liveSearchResults').html(response);
                    }
                });
            }
        });
$(window).on('load', function () {
    // Hide the preloader when the page is fully loaded
    $('.preloader').fadeOut('slow');
});

    </script>
</body>

</html>
