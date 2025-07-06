<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); // connection to db
error_reporting(0);
session_start();

include_once 'product-action.php'; //including controller

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

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
    <link href="css/reviewcss.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Custom live search script -->
    <script>
        $(document).ready(function () {
            $("#search-box").on("input", function () {
                var query = $(this).val().toLowerCase();
                $(".food-item").each(function () {
                    var title = $(this).find(".rest-descr h3 a").text().toLowerCase();
                    var price = $(this).find(".price").text().toLowerCase();
                    var isVisible = title.includes(query) || price.includes(query);

                    // Check for related results
                    if (!isVisible) {
                        // Split the query into words
                        var words = query.split(' ');

                        // Check if any of the words match with title or price
                        for (var i = 0; i < words.length; i++) {
                            if (title.includes(words[i]) || price.includes(words[i])) {
                                isVisible = true;
                                break;
                            }
                        }
                    }

                    isVisible ? $(this).show() : $(this).hide();
                });
            });
        });
    </script>

    <style>
        body {
            background-image: url('images/background_image.gif') !important;
        }
    </style>
</head>

<body>

    <?php
    include("header.php");
    ?>
    <div class="page-wrapper" style="padding:0px;">
        <!-- top Links -->
        <!-- end:Top links -->
        <!-- start: Inner page hero -->
        <?php $ress = mysqli_query($db, "select * from restaurant where rs_id='$_GET[res_id]'");
        $rows = mysqli_fetch_array($ress);

        ?>
        <section class="inner-page-hero bg-image" style="padding-top:40px" data-image-src="images/img/show.jpeg">
            <div class="profile">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img" style="padding-top:100px;">
                            <div class="image-wrap" ">
                                    <figure><?php echo '<img src="admin/Res_img/' . $rows['image'] . '" alt="Restaurant logo">'; ?></figure>
                                </div>
                            </div>
                            
                            <div class=" col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                                <div class="pull-left right-text white-txt"
                                    style="padding-top:100px;text-align:right;font-size:18px;">
                                    <h6><a href="#">
                                            <?php echo $rows['title']; ?>
                                        </a></h6>
                                    <p>
                                        <?php echo $rows['address']; ?>
                                    </p>
                                    <ul class="nav nav-inline">
                                        <li class="nav-item"> <a class="nav-link active" href="#"><i
                                                    class="fa fa-check"></i><span style='color:white'> Min ₹
                                                    10,00</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" href="#"><i
                                                    class="fa fa-motorcycle"></i><span style='color:white'> 30
                                                    min</span></a> </li>
                                        <li class="nav-item ratings">
                                            <a class="nav-link" href="#"> <span style='color:white'>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </span> </a>
                                        </li>
                                    </ul>
                                    <?php
                                    // Include the QR code generator file
                                    include 'qr-code/generate_qr.php';
                                  
                                    // Call the function to generate QR code as a string
                                    $link = "http://192.168.29.14:80/localhost/realtime/dishes.php?res_id=$res_id";
                                    $qrCodeString = generateQRCodeAsString($link);

                                    // Use the QR code string as needed, for example, embedding it in an HTML img tag
                                    echo '<img src="data:image/png;base64,' . $qrCodeString . '" alt="QR Code">';
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </section>

        <!-- end:Inner page hero -->
        <div class="breadcrumb">
            <div class="container">
                <?php
                $restaurants = $_SESSION['distances'];
                $rid = $_GET['res_id'];
                $isAvailable = true;
                foreach ($restaurants as $row) {
                    if ($row['rs_id'] == $rid && $row["distance"] >= 10) {
                        $isAvailable = false;
                        echo '<h1 style="color:red">Currently Not Available At Your Place</h1>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="container m-t-30">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3" style="display:none">

                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                Your Shopping Cart
                            </h3>


                            <div class="clearfix"></div>
                        </div>
                        <div class="order-row bg-white">
                            <div class="widget-body">


                                <?php

                                $item_total = 0;

                                foreach ($_SESSION["cart_item"] as $item)  // fetch items define current into session ID
                                {
                                    ?>

                                    <div class="title-row">
                                        <?php echo $item["title"]; ?><a
                                            href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>">
                                            <i class="fa fa-trash pull-right"></i></a>
                                    </div>

                                    <div class="form-group row no-gutter">
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control b-r-0" value=<?php echo "₹" . $item["price"]; ?> readonly id="exampleSelect1">

                                        </div>
                                        <div class="col-xs-4">
                                            <input class="form-control" type="text" readonly
                                                value='<?php echo $item["quantity"]; ?>' id="example-number-input">
                                        </div>

                                    </div>

                                    <?php
                                    $item_total += ($item["price"] * $item["quantity"]); // calculating current price into cart
                                }
                                ?>



                            </div>
                        </div>

                        <!-- end:Order row -->

                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL</p>
                                <h3 class="value"><strong>
                                        <?php echo "₹" . $item_total; ?>
                                    </strong></h3>
                                <p>Free Shipping</p>
                                <?php
                                if ($item_total == 0) {
                                    echo '<button type="button"
                                            class="btn theme-btn btn-lg" disabled >Checkout</a>';
                                } else {
                                    ?>

                                    <a href="checkout.php?res_id=<?php echo $_GET['res_id']; ?>&action=check"
                                        class="btn theme-btn btn-lg">Checkout</a>
                                <?php } ?>
                            </div>
                        </div>




                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-12">

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-8 col-lg-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" style="color:white;font-size: 25px;">Search :</span>
                                    <input type="text" class="form-control" id="search-box"
                                        placeholder="Search for food items">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add this where you want to display live search results -->
                    <div id="food-results"></div>


                    <div class="menu-widget" id="2" style="background:none;border:none">
                        <div class="widget-heading">
                            <h3 class="widget-title" style="font-size:25px;color:white">
                                All Dishes <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2"
                                    aria-expanded="true">
                                    <i class="fa fa-angle-right pull-right"></i>
                                    <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="collapse in" id="popular2">
                            <?php  // display values and item of food/dishes
                            
                            $stmt = $db->prepare("SELECT * FROM dishes WHERE rs_id='$_GET[res_id]'");
                            $stmt->execute();
                            $products = $stmt->get_result();

                            if (!empty($products)) {
                                foreach ($products as $product) {

                                    ?>
                                    <div class="food-item" style="color:white">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-lg-8">
                                                <form method="post"
                                                    action='dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=add&id=<?php echo $product['d_id']; ?>'>
                                                    <div class="rest-logo pull-left">
                                                        <a class="restaurant-logo pull-left" href="#">
                                                            <?php echo '<img src="admin/Res_img/dishes/' . $product['img'] . '" alt="Food logo" width="100%" height="100%">'; ?>
                                                        </a>
                                                    </div>
                                                    <!-- end:Logo -->
                                                    <div class="rest-descr">
                                                        <h3><a href="#" style="font-size:34px">
                                                                <?php echo $product['title']; ?>
                                                            </a></h3>
                                                        <p style="font-size:20px">
                                                            <?php echo $product['slogan']; ?>
                                                        </p>
                                                    </div>
                                                    <!-- end:Description -->
                                            </div>
                                            <!-- end:col -->
                                            <div class="col-xs-12 col-sm-2 col-lg-4 pull-right item-cart-info">
                                                <span class="price pull-left" style="font-size:18px">₹
                                                    <?php echo $product['price']; ?>
                                                </span>
                                                <?php if ($isAvailable) {
                                                    echo '<input type="button" value="-" id="minusBtn" class="btn btn-danger" style="margin-left:10px">
                                                    <input class="b-r-0" type="number" name="quantity" style="width: 20%;font-size:20px; border-right: 2px solid black;" value="1" size="2" />
                                                    <input type="button" value="+" id="plusBtn" class="btn btn-success"><br>                                                    
                                                    <input type="submit" class="btn theme-btn add-to-cart-btn" style="margin-left: 100px;margin-top:10px; font-size: 20px;" value="Add to cart" id="addToCart" />';
                                                } else {
                                                    echo '<span style="margin-left:40px;font-size:20px;color:red"> Unavailable</span>';
                                                }
                                                ?>
                                            </div>

                                            </form>
                                        </div>
                                        <!-- end:row -->
                                    </div>
                                    <!-- end:Food item -->

                                    <?php
                                }
                            }

                            ?>

                        </div>
                        <!-- end:Collapse -->
                    </div>
                    <!-- end:Widget menu -->

                </div>
                <!-- end:Bar -->

            </div>
            <!-- end:row -->
        </div>
        <!-- end:Footer -->
    </div>
    <!-- end:page wrapper -->
    </div>
    <!--/end:Site wrapper -->

    <br><br>

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

    <?php
    // Assuming you have the rs_id in the $_GET array
    $rs_id = isset($_GET['res_id']) ? $_GET['res_id'] : null;
    $query = "SELECT * FROM feedback WHERE rs_id = $rs_id ORDER BY submission_date DESC LIMIT 6";

    // Assuming $db is your database connection
    $result = mysqli_query($db, $query);

    $reviews = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }

    if (empty($reviews)) {
        echo "<section class='review' id='review'>";
        echo "<h1 class='heading' style='color:white'>Customer's <span>Review</span></h1>";
        echo "<h3 style='color:white'>Feedbacks not available. Be the first to add your review!</h3> </section>";
    } else {
        ?>

        <section class="review" id="review">
            <h1 class="heading" style="color:orange">Customer's <span>Review</span></h1>
            <div id="reviewCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <?php $count = 0; ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="col-md-4">
                                    <div class="card shadow-sm" style="border-radius:19%">
                                        <img class="card-img-top" src="images/restaurants/user.jpg" alt="User Image" width="300"
                                            height="190" style="border-radius:100%">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php echo $review['name']; ?>
                                            </h5>
                                            <p class="card-text">
                                                <?php echo $review['message']; ?>
                                            </p>
                                            <div class="star-rating" data-rating="<?php echo $review['rating']; ?>">
                                                <?php
                                                for ($i = 1; $i <= $review["rating"]; $i++) {
                                                    $filledClass = ($i <= $review['rating']) ? 'fas fa-star filled' : 'far fa-star';
                                                    echo '<span class="' . $filledClass . '"></span>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $count++; ?>
                                <?php if ($count % 3 == 0 && $count != count($reviews)): ?>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#reviewCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#reviewCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </section>
    <?php } ?>


    <div style="margin:50px;padding:10px">
        <iframe style="border:none" src="feedback/restaurant_feedback.php?rs_id=<?php echo $_GET['res_id']; ?>"
            width="100%" height="920px"></iframe>
    </div>
    <div id="map"></div>

    <?php
    include('footer.php'); ?>
    <script src="css/reviewscript.js"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script>
        // Replace with your user address (keep it static)
        var userAddress = "godavari college of engineering,jalgaon";

        function initMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: { lat: 37.7749, lng: -122.4194 } // Default center (San Francisco)
            });
            directionsRenderer.setMap(map);

            // Get the restaurant address dynamically from the server-side (PHP)
            var restaurantAddress = "<?php echo getRestaurantAddressFromDatabase(); ?>";
            console.log("Restaurant Address:", restaurantAddress);
            var request = {
                origin: userAddress,
                destination: restaurantAddress,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function (response, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

        // Function to retrieve restaurant address from the database using PHP
        <?php
        function getRestaurantAddressFromDatabase()
        {
            include("connection/connect.php");

            // Assuming res_id is passed in the URL
            $rs_id = $_GET['res_id'];

            if ($rs_id) {
                $query = "SELECT address FROM restaurant WHERE rs_id = $rs_id";
                $result = mysqli_query($db, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $restaurantAddress = $row['address'];
                    echo "return '$restaurantAddress';";
                } else {
                    // Default restaurant address if not found
                    echo "return 'jalgaon';";
                }
            }
        }
        ?>
    </script>
    <script>
        document.getElementById('plusBtn').addEventListener('click', function () {
            var quantityInput = document.querySelector('input[name="quantity"]');
            var currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
        });

        document.getElementById('minusBtn').addEventListener('click', function () {
            var quantityInput = document.querySelector('input[name="quantity"]');
            var currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
            }
        });
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCP8nKjC3oW1A-z70ef1-crdc2_EQGDQJQ&callback=initMap"></script>

</body>

</html>