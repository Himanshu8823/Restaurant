<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
include("distance.php");
$res_categories = mysqli_query($db, "SELECT * FROM res_category");
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
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
    <style>
        .theme-btn-dash {
            color: blueviolet;
            background-color: white;
            border-color: blueviolet;
        }

        .theme-btn-dash:hover {
            color: white;
            background-color: blueviolet;
            border-color: blueviolet;
        }

        body {
            background-image: url('images/background_image.gif');

        }

        .selected {
            background-color: blue;
            color: white;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="dot-spinner">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <?php
    include("header.php");
    ?>

    <div class="page-wrapper">
        <!-- top Links -->

        <!-- Add this input field at the top of your page -->
        <div class="search-container" style="padding-top:2%">
            <center style="font-size:26px;color:white;font-weight:bold  ">Search : <input type="text"
                    id="liveSearchInput" placeholder="Search for restaurants..."
                    style="width:50%;font-size:22px;font-weight:normal;display:inline-block"></center>
        </div>

        <div class="container"> </div>
        <!-- end:Container -->
    </div>
    <div class="result-show">
        <div class="container">
            <div class="row">


            </div>
        </div>
    </div>
    <!-- //results show -->
    <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">

        <div class="widget clearfix">
            <!-- /widget heading -->
            <div class="widget-heading">
                <h3 class="widget-title text-dark">
                    Filters
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <ul class="tags">
                    <!-- Add the "All" option at the beginning -->
                    <li style="font-size:20px;display: block;width: 100%;" onclick="filterRestaurants('All', this)"
                        class="tag selected">All</li>
                    <?php
                    // Display categories fetched from the database
                    while ($row = mysqli_fetch_array($res_categories)) {
                        echo '<li style="font-size:20px;display: block;width: 100%;" onclick="filterRestaurants(\'' . $row['c_name'] . '\', this)" class="tag">' . $row['c_name'] . '</li>';
                    }
                    ?>
                </ul>

            </div>
        </div>
        <!-- end:Widget -->
    </div>
    <section class="restaurants-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9" style="background-color:white">
                    <div class="bg-gray restaurant-entry" id="restaurantContainer">
                        <div class="row">
                            <?php
                            $userAddress = "godavari college of engineering,jalgaon";
                            $sql = "SELECT * FROM restaurant";
                            $result = $db->query($sql);
                            if ($result) {
                                // Check if there are rows in the result
                                if ($result->num_rows > 0) {
                                    $restaurants = [];

                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        // Calculate distance using the getDistance function from distance_helper.php
                                        $distance = getDistance(
                                            $userAddress,
                                            $row['address'],
                                            "K" // You can change the unit if needed
                                        );

                                        $row['distance'] = $distance;
                                        $restaurants[] = $row;

                                    }
                                    // Now, $restaurants array contains all restaurants with the calculated distances
                                }
                            }
                            $_SESSION['distances'] = $restaurants;
                            $googleMapsApiKey = "AIzaSyCP8nKjC3oW1A-z70ef1-crdc2_EQGDQJQ";
                            foreach ($restaurants as $rows) {
                                echo ' <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
                                                                <div class="entry-logo">
                                                                    <a class="img-fluid" href="dishes.php?res_id=' . $rows['rs_id'] . '" > <img src="admin/Res_img/' . $rows['image'] . '" alt="Food logo"></a>
                                                                </div>
                                                                <!-- end:Logo -->
                                                                <div class="entry-dscr">
                                                                    <h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . '</a></h5> <span>' . $rows['address'] . ' <a href="#">...</a></span>
                                                                    <ul class="list-inline">
                                                                        <li class="list-inline-item"><i class="fa fa-check"></i> Min $ 10,00</li>
                                                                        <li class="list-inline-item"><i class="fa fa-motorcycle"></i> 30 min</li>                                                            
                                                                        <li class="list-inline-item"><i class="fa fa-road"></i> Distance : ' . $rows['distance'] . '</li>                                                            
                                                                    </ul>
                                                                </div>
                                                                <!-- end:Entry description -->
                                                            </div>  
                                                            
                                                            <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
                                                                    <div class="right-content bg-white">
                                                                        <div class="right-review">
                                                                            <div class="rating-block" style="color:gold"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>';
                                if ($rows["distance"] <= 10) {
                                    echo "<p style='color:green;margin-right:10px'>Available</p>";
                                } else {
                                    echo "<span style='color:Red;'>Currently Unavailable</span>";
                                }
                                echo '<a href="dishes.php?res_id=' . $rows['rs_id'] . '" class="btn theme-btn-dash">View Menu</a> </div>
                                                                    </div>
                                                                    <!-- end:right info -->
                                                                </div>';
                            }
                            ?>

                        </div>
                        <!--end:row -->
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>

    <!-- start: FOOTER -->
    <br>
    <?php include('footer.php'); ?>
    <!-- end:Footer -->
    </div>


    <!-- Bootstrap core JavaScript
        ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script>
        // Function to handle live search
        $(document).ready(function () {
            $('#liveSearchInput').on('input', function () {
                var query = $(this).val();

                // Make an AJAX request to fetch restaurants based on the search query
                $.ajax({
                    type: 'POST',
                    url: 'search_restaurants.php', // Create this PHP file to handle the search
                    data: { query: query },
                    success: function (response) {
                        // Update the content of the restaurant container with the search results
                        $('#restaurantContainer').html(response);
                    },
                    error: function (error) {
                        console.error('Error performing live search:', error);
                    }
                });
            });
        });
        $(window).on('load', function () {
            // Hide the preloader when the page is fully loaded
            $('.preloader').fadeOut('slow');
        });


    </script>
    <script>
        var allRestaurantsData; // Variable to store all restaurants data

        $(document).ready(function () {
            // Function to fetch and store all restaurants data when the page loads
            fetchAllRestaurantsData();
        });

        function fetchAllRestaurantsData() {
            // Fetch all restaurants data directly within this PHP script
            <?php
            $restaurants = $_SESSION['distances'];
            echo "allRestaurantsData = " . json_encode($restaurants) . ";";
            ?>
        }

        function filterRestaurants(categoryName, element) {
            // If "All" is selected, display all restaurants using the stored data
            if (categoryName === 'All') {
                displayAllRestaurants();
                return; // Exit the function
            }

            // Otherwise, filter restaurants based on the selected category
            $.ajax({
                type: 'POST',
                url: 'filter_restaurants.php',
                data: { categoryName: categoryName },
                success: function (response) {
                    // Update the restaurant container with the filtered restaurants
                    $('#restaurantContainer').html(response);
                    // Remove the 'selected' class from all <li> elements
                    $('ul.tags li').removeClass('selected');
                    // Add the 'selected' class to the clicked <li> element
                    $(element).addClass('selected');
                },
                error: function (error) {
                    console.error('Error filtering restaurants:', error);
                }
            });
        }

        function displayAllRestaurants() {
            // Update the restaurant container with all restaurants data
            // Use the stored allRestaurantsData directly
            $('#restaurantContainer').html(renderAllRestaurants());
            // Remove the 'selected' class from all <li> elements
            $('ul.tags li').removeClass('selected');
            // Add the 'selected' class to the "All" <li> element
            $('ul.tags li:contains("All")').addClass('selected');
        }

        // Function to render HTML for all restaurants using the stored data
        // Function to render HTML for all restaurants using the stored data
        // Function to render HTML for all restaurants using the stored data
        function renderAllRestaurants() {
            var html = '';
            allRestaurantsData.forEach(function (restaurant) {
                html += '<div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">';
                html += '<div class="entry-logo">';
                html += '<a class="img-fluid" href="dishes.php?res_id=' + restaurant['rs_id'] + '">';
                html += '<img src="admin/Res_img/' + restaurant['image'] + '" alt="Food logo"></a></div>';
                html += '<div class="entry-dscr">';
                html += '<h5><a href="dishes.php?res_id=' + restaurant['rs_id'] + '">' + restaurant['title'] + '</a></h5>';
                html += '<span>' + restaurant['address'] + ' <a href="#">...</a></span>';
                html += '<ul class="list-inline">';
                html += '<li class="list-inline-item"><i class="fa fa-check"></i> Min $ 10,00</li>';
                html += '<li class="list-inline-item"><i class="fa fa-motorcycle"></i> 30 min</li>';
                html += '<li class="list-inline-item"><i class="fa fa-road"></i> Distance : ' + restaurant['distance'] + '</li>';
                html += '</ul></div></div>';
                html += '<div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">';
                html += '<div class="right-content bg-white">';
                html += '<div class="right-review">';
                html += '<div class="rating-block" style="color:gold">';
                html += '<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i>';
                html += '</div>';
                if (parseFloat(restaurant['distance']) <= 10) {
                    html += '<p style="color:green;margin-right:10px">Available</p>';
                } else {
                    html += '<span style="color:red;">Currently Unavailable</span>';
                }

                html += '<a href="dishes.php?res_id=' + restaurant['rs_id'] + '" class="btn theme-btn-dash">View Menu</a>';
                html += '</div></div></div>';
            });
            return html;
        }



    </script>

</body>

</html>