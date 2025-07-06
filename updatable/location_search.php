<?php
// Include your existing database connection
include("connection/connect.php");
session_start();

// Include the distance calculation helper
include("distance.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user's address from the form
    $userAddress = $_POST["user_address"];

    // Replace this with your actual Google Maps API key
    $googleMapsApiKey = "AIzaSyCP8nKjC3oW1A-z70ef1-crdc2_EQGDQJQ";

    // Fetch all restaurants from the database
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
}
?>
<!-- The rest of your HTML code remains unchanged -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Himanshu's Online Food Ordering System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        
        .result-item {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
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

        .distance,
        .rating,
        .review {
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
            white-space: pre-line;
            min-height: 4em;
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
    <script>
        function useCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    document.getElementById('user_address').value = position.coords.latitude + ', ' + position.coords.longitude;
                    location_form.submit();
                    document.getElementById('user_address').value = "";
                }, function (error) {
                    console.error("Error getting current location:", error.message);
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }
    </script>
</head>

<body>
    <?php include("header.php"); ?>
    <br><br><br><br><br>
    <center>
        <div class="container mt-5">
            <form method="post" action="" name="location_form">
                <div class="form-group">
                    <h1><label for="user_address">Enter Your Location:</label></h1>
                    <input type="text" class="form-control" id="user_address" name="user_address" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="useCurrentLocation()">Use Your Current
                    Location</button>
                <button type="submit" class="btn btn-success">Find Restaurants</button>
                <a class="btn btn-primary" href="search.php">Go To Search Directly page </a>
            </form>
            <br><br><br>
            <center>
                <h2>
                    Restaurants
                    
                </h2>
            </center>
            <br><br><br>
            <!-- Display the results here -->
            <!-- Display the results here -->
            <!-- Display the results here -->
<?php if (isset($restaurants) && !empty($restaurants)): ?>
    <div class="row mt-4">
        <?php foreach ($restaurants as $row): ?>
            <div class="col-xs-12 col-sm-6 col-md-4 food-item restaurant-card" style="border-radius:40%">
                <div class="food-item-wrap">
                <div class="figure-wrap bg-image" data-image-src="admin/Res_img/<?php echo $row['image']; ?>">
    <?php
    $restaurantImagePath = 'admin/Res_img/' . $row['image'];
    $defaultRestaurantImagePath = 'path_to_default_image.jpg';
    ?>
    <img src="<?php echo (file_exists($restaurantImagePath) ? $restaurantImagePath : $defaultRestaurantImagePath); ?>" alt="Restaurant Image">

    <!-- Calculate and display the actual distance here -->
    <div class="distance" style="position:relative; margin-left: 70%;margin-right:5px ;">
        <i class="fa fa-map-pin"></i>
        <?php echo $row['distance']; ?>
    </div>
</div>

                    <div class="content">
                        <?php $rs_id = isset($row['rs_id']) ? $row['rs_id'] : ''; ?>
                        <h5><a href="dishes.php?res_id=<?php echo $rs_id; ?>">
                                <?php echo $row['title']; ?>
                            </a></h5>
                        <div class="product-name">
                            <?php echo $row['address']; ?>
                        </div>
                        <div class="price-btn-block">
                            <a href="dishes.php?res_id=<?php echo $rs_id; ?>"
                                class="btn theme-btn-dash pull-right">View menu</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php elseif (isset($restaurants) && empty($restaurants)): ?>
    <p>No restaurants found within 50 km.</p>
<?php endif; ?>


        </div>
    </center>
</body>

</html>