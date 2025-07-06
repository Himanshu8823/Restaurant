<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");  //include connection file
include('config.php');
error_reporting(0);  // using to hide undefine undex errors
session_start(); //start temp session until logout/browser closed
?>

<head>
    <style>
        .home {
            width: 100%;
            height: 700px;
        }

        .slider {
            width: 100%;
            height: 400px;
            position: sticky;
            margin-bottom: 50px;
            left: 0px;
            top: 0px;
        }

        .slider img {
            width: 100%;
            height: 450px;
            position: absolute;
            top: 0;
            left: 0;
            /* transition: all 0.5s ease-in-out; */
        }

        .slider img:first-child {
            z-index: 1;
        }

        .slider img:nth-child(2) {
            z-index: 0;
        }

        .navigation-button-btn {
            text-align: center;
            position: relative;
        }

        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }
        .navbar {
            background-color: transparent !important;
            border: none;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
            /* Ensure the navbar is on top of other elements */
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: #fff;
            /* Set the color of the mobile menu icon */
        }
    </style>
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
    <link href="css/reviewcss.css" rel="stylesheet">
    <style>
        .product-name {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            word-wrap: break-word;            
            white-space: pre-line;            
            min-height: 4em;            
        }
        body{
            background-image:url('images/background_image.gif');
            
        }
    </style>
</head>

<body class="home" 
    <?php
    include("header.php")
        ?>
    <br<br><br><br><br>
    <div class="slider-container">
    <div class="slider" style="width:100%">
        <?php
        // Fetch image URLs from the database
        $query = "SELECT image_url FROM slider_images LIMIT 6";
        $result = mysqli_query($db, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<img src=\"images/business-banners/{$row['image_url']}\" alt=\"Banner Image\" />";
            }
        }
        ?>
    </div>

</div>

<div class="navigation-button-btn">
    <?php
    // Reset result pointer
    mysqli_data_seek($result, 0);

    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<span style='background-color:silver' class=\"dot" . ($index === 0 ? " active" : "") . "\" onclick=\"currentSlide($index)\"></span>";
        $index++;
    }
    ?>
</div>

<script>
    var slideIndex = 0;
    showSlides();
    
    function showSlides() {
        var i;
        var slides = document.getElementsByClassName("slider")[0].getElementsByTagName("img");
        var dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slideIndex++;
        if (slideIndex > slides.length) { slideIndex = 1 }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        setTimeout(showSlides, 3000); // Change slide every 3 seconds
    }

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }
</script>

<style>
    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }
    .restaurant-details {
    height: 6em; /* Set height for the address section */
    overflow: hidden; /* Hide overflow content */
}

</style>

        <!-- banner part ends -->
        <!-- Popular block starts -->
        <section class="popular">
            <div class="container">
                <div class="title text-xs-center m-b-30">
                    <h1 style="color:orange">Popular Dishes of the Month</h1>
                    <p style="color:white" class="lead">The easiest way to your favourite food</p>
                </div>
                <div class="row">            
                    <?php
                    // fetch records from database to display popular first 6 dishes from table
                    $query_res = mysqli_query($db, "
    SELECT d.*, COUNT(uo.o_id) AS order_count
    FROM dishes d
    LEFT JOIN users_orders uo ON d.d_id = uo.d_id
    WHERE uo.status = 'closed' or uo.status='in process' or uo.status is NULL
    AND MONTH(uo.date) = MONTH(CURRENT_TIMESTAMP())
    AND YEAR(uo.date) = YEAR(CURRENT_TIMESTAMP())
    GROUP BY d.d_id
    ORDER BY order_count DESC
    LIMIT 6
");

                    while ($r = mysqli_fetch_array($query_res)) {

                        echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
														<div class="food-item-wrap" style="border-radius:10%">
															<div class="figure-wrap bg-image" data-image-src="admin/Res_img/dishes/' . $r['img'] . '">																
																<div class="rating pull-left"> <i class="fa fa-star"style="color:gold"></i> <i class="fa fa-star"style="color:gold"></i> <i class="fa fa-star"  style="color:gold"></i> <i class="fa fa-star" style="color:gold"></i> <i class="fa fa-star"></i> </div>
																<div class="review pull-right"><a href="#">198 reviews</a> </div>
															</div>
															<div class="content">
																<h5><a href="dishes.php?res_id=' . $r['rs_id'] . '">' . $r['title'] . '</a></h5>
																<div class="product-name">' . $r['slogan'] . '</div>
																<div class="price-btn-block"> <span class="price" style="color:darkgold">₹' . $r['price'] . '</span> <a href="dishes.php?res_id=' . $r['rs_id'] . '" class="btn theme-btn-dash pull-right">Order Now</a> </div>
															</div>
															
														</div>
												</div>';

                    }
                    ?>

                </div>
            </div>
        </section>
        <!-- Popular block ends -->
        
        <!-- Featured restaurants starts -->
        <section class="featured-restaurants">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="title-block pull-left">
                            <h1 style="color:orange;font-family">Featured restaurants</h2>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <!-- restaurants filter nav starts -->
                        <div class="restaurants-filter pull-right">
                            <nav class="primary pull-left">
                                <ul>
                                    <li><a href="#" class="selected" data-filter="*" style="color:white;font-size:20px">all</a> </li>
                                    <?php
                                    // display categories here
                                    $res = mysqli_query($db, "select * from res_category");
                                    while ($row = mysqli_fetch_array($res)) {
                                        echo '<li><a href="#" style="color:white;font-size:20px" data-filter=".' . $row['c_name'] . '"> ' . $row['c_name'] . '</a> </li>';
                                    }
                                    ?>

                                </ul>
                            </nav>
                        </div>
                        <!-- restaurants filter nav ends -->
                    </div>
                </div>
                <!-- restaurants listing starts -->
                <div class="row">
                    <div class="restaurant-listing">


                        <?php  //fetching records from table and filter using html data-filter tag
                        $ress = mysqli_query($db, "select * from restaurant");
                        while ($rows = mysqli_fetch_array($ress)) {
                            // fetch records from res_category table according to catgory ID
                            $query = mysqli_query($db, "select * from res_category where c_id='" . $rows['c_id'] . "' ");
                            $rowss = mysqli_fetch_array($query);

                                    echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 single-restaurant all ' . $rowss['c_name'] . '">
                                    <div class="restaurant-wrap" style="border-radius:10%">
                                        <div class="row">
                                            <div class="col-xs-12 text-xs-center">
                                                <a class="restaurant-logo" href="dishes.php?res_id=' . $rows['rs_id'] . '" > <img src="admin/Res_img/' . $rows['image'] . '" alt="Restaurant logo" style="height:100px;border-radius:30%" > </a>
                                            </div>
                                            <!--end:col -->
                                            <div class="col-xs-12">
                                                <h5><a href="dishes.php?res_id=' . $rows['rs_id'] . '" >' . $rows['title'] . '</a></h5> 
                                                <div class="restaurant-details">
                                                    <p> '.$rows["address"].' </p>
                                                </div>
                                                <div class="bottom-part">
                                                    <div class="cost"><i class="fa fa-check"></i> Min $ 10,00</div>
                                                    <div class="mins"><i class="fa fa-motorcycle"></i> 30 min</div>
                                                    <div class="ratings"> <span style="color:orange">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </span> (122) </div>
                                                </div>
                                            </div>
                                            <!-- end:col -->
                                        </div>
                                        <!-- end:row -->
                                    </div>
                                    <!--end:Restaurant wrap -->
                                </div>';
                            
                        }

                        ?>
                    </div>
                </div>
                <!-- restaurants listing ends -->

            </div>
        </section>
        
        <?php include("sliders.php"); ?>
        <br>
        <!-- Featured restaurants ends -->

        <!-- start: FOOTER -->
        <iframe src="feedback/website_feedback.php" height="160%" width="100%" style="border:none"></iframe>
        <?php
        include('footer.php'); ?>
</body>

</html>
</footer>
<!-- end:Footer -->

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
<script src="css/reviewscript.js"></script>

</body>

</html>