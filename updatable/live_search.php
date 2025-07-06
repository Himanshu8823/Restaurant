<?php
// live_search.php
session_start();
include("connection/connect.php");
?>
<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>Starter Template for Bootstrap</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
    <style>
    .food-item {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .restaurant-card {
        height: 450px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .figure-wrap {
        height: 70%;
        position: relative;
    }

    .figure-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .distance, .rating, .review {
        color: gold;
    }

    .content {
        display: flex;
        flex-direction: column;
        padding: 10px;
        box-sizing: border-box;
    }

    .content h5 {
        margin-bottom: 10px;
    }

    .product-name {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    word-wrap: break-word;
    /* Add the following lines to handle one-line addresses */
    white-space: pre-line; /* Preserve whitespace and treat each line break as a new line */
    min-height: 4em; /* Set a minimum height to simulate two lines */
}


    .price-btn-block {
        height: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    body{
            background-image: url('images/background_image.gif');
        }
        h1{
            color:orange
        }
        h2{
            color:wheat
        }
</style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Function to add a dish to the cart
        function addToCart(dishId, restaurantId) {
            // Send an AJAX request to your backend to add the item to the cart
            $.ajax({
                type: 'GET',
                url: 'product-action.php?', // Update with the correct URL for your product-action.php file
                data: {
                    action: 'add',
                    id: dishId,
                    res_id: restaurantId,
                    quantity: 1 // You can modify this value as needed
                },
                success: function (response) {
                    // Handle the response (e.g., show a success message)
                    
                },
                error: function () {
                    // Handle the error (e.g., show an error message)
                    alert('Error adding item to cart.');
                }
            });
        }
    </script>
</head>
<body>

<?php
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$search_query = mysqli_real_escape_string($db, $search_query);

// Perform search logic for dishes, categories, and restaurants
$query_res = mysqli_query($db, "
    SELECT d.d_id, d.rs_id, d.title AS dish_title, d.slogan AS dish_slogan, d.price AS dish_price, d.img AS dish_img,
           r.rs_id AS restaurant_id, r.title AS restaurant_title, r.address AS restaurant_address,
           c.c_name AS category_name
    FROM dishes AS d
    LEFT JOIN restaurant AS r ON d.rs_id = r.rs_id
    LEFT JOIN res_category AS c ON r.c_id = c.c_id
    WHERE d.title LIKE '%$search_query%'
       OR r.title LIKE '%$search_query%'
       OR r.address LIKE '%$search_query%'
       OR c.c_name LIKE '%$search_query%'
    LIMIT 20
");
echo '<div class="col-xs-12"><h1>Dishes Category</h1><br></div>';
// Display live search results
while ($row = mysqli_fetch_assoc($query_res)) {
    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item restaurant-card" style="border-radius:12%">';
    echo '<div class="food-item-wrap">';
    echo '<div class="figure-wrap bg-image" data-image-src="admin/Res_img/dishes/' . $row['dish_img'] . '">';
    
    // Check if the image file exists, otherwise, display a default image
    $imagePath = 'admin/Res_img/dishes/' . $row['dish_img'];
    $defaultImagePath = 'path_to_default_image.jpg';

    echo '<img src="' . (file_exists($imagePath) ? $imagePath : $defaultImagePath) . '" alt="Dish Image">';
    
    echo '<div class="distance"><i class="fa fa-map-pin"></i>1240m</div>';
    echo '<div class="rating pull-left"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>';
    echo '<div class="review pull-right"><a href="#">198 reviews</a> </div>';
    echo '</div>';
    echo '<div class="content">';
    
    // Check if rs_id is set before using it
    $rs_id = isset($row['rs_id']) ? $row['rs_id'] : '';

    echo '<h5><a href="dishes.php?res_id=' . $rs_id . '&dish_id=' . $row['d_id'] . '">' . $row['dish_title'] . '</a></h5>';
    echo '<div class="product-name">' . $row['dish_slogan'] . '</div>';
    echo '<div class="price-btn-block"> <span class="price">₹' . $row['dish_price'] . '</span> <button onclick="addToCart(' . $row['d_id'] . ', ' . $row['rs_id'] . ')" class="btn theme-btn-dash pull-right">Order Now</button> </div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// You can modify the query to include the restaurant information in the search results
$query_res_restaurants = mysqli_query($db, "
    SELECT DISTINCT r.rs_id, r.image AS restaurant_image, r.title AS restaurant_title, r.address AS restaurant_address
    FROM restaurant AS r
    LEFT JOIN res_category AS c ON r.c_id = c.c_id
    WHERE r.title LIKE '%$search_query%'
       OR r.address LIKE '%$search_query%'
       OR c.c_name LIKE '%$search_query%'
");
echo '<div class="col-xs-12"><h1>Restaurants</h1><br></div>';
// Display live search results for restaurants
while ($row = mysqli_fetch_assoc($query_res_restaurants)) {
    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item restaurant-card" style="border-radius:10%;">';
    echo '<div class="food-item-wrap">';
    echo '<div class="figure-wrap bg-image" data-image-src="admin/Res_img/' . $row['restaurant_image'] . '">';
    // Check if the image file exists, otherwise, display a default image
    $restaurantImagePath = 'admin/Res_img/' . $row['restaurant_image'];
    
    $defaultRestaurantImagePath = 'path_to_default_image.jpg';
    
    echo '<img src="' . (file_exists($restaurantImagePath) ? $restaurantImagePath : $defaultRestaurantImagePath) . '" alt="Restaurant Image">';
    
    echo '<div class="distance"><i class="fa fa-map-pin"></i>1240m</div>';
    // Add additional styling or information for restaurant cards if needed
    echo '</div>';
    echo '<div class="content">';
    
    // Check if rs_id is set before using it
    $rs_id = isset($row['rs_id']) ? $row['rs_id'] : '';

    echo '<h5><a href="restaurant.php?res_id=' . $rs_id . '">' . $row['restaurant_title'] . '</a></h5>';
    echo '<div class="product-name">' . $row['restaurant_address'] . '</div>';
    echo '<div class="price-btn-block"> <a href="dishes.php?res_id=' . $rs_id . '" class="btn theme-btn-dash pull-right">View menu</a> </div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

</body>
</html>
