<?php
// Include your database connection and any required functions
include("connection/connect.php");
session_start();

// Check if the categoryName is set in the request
if(isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    
    // Fetch the restaurants based on the selected category
    $query = "SELECT * FROM restaurant WHERE c_id IN (SELECT c_id FROM res_category WHERE c_name = '$categoryName')";
    $result = mysqli_query($db, $query);

    // Start buffering the output
    ob_start();

    // Generate HTML for the filtered restaurant listings
    while ($row = mysqli_fetch_assoc($result)) {
        // Generate HTML for each restaurant listing
        ?>
        <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
            <!-- Add your HTML for each restaurant listing here -->
            <!-- Example: -->
            <div class="entry-logo">
                <a class="img-fluid" href="dishes.php?res_id=<?php echo $row['rs_id']; ?>">
                    <img src="admin/Res_img/<?php echo $row['image']; ?>" alt="Food logo">
                </a>
            </div>
            <div class="entry-dscr">
                <h5><a href="dishes.php?res_id=<?php echo $row['rs_id']; ?>"><?php echo $row['title']; ?></a></h5>
                <span><?php echo $row['address']; ?> <a href="#">...</a></span>
                <ul class="list-inline">
                    <li class="list-inline-item"><i class="fa fa-check"></i> Min $ 10,00</li>
                    <li class="list-inline-item"><i class="fa fa-motorcycle"></i> 30 min</li>                                                            
                    <li class="list-inline-item"><i class="fa fa-road"></i> Distance: 
                        <?php 
                        // Find the distance from the session data
                        $distance = findDistance($row['rs_id']);
                        echo $distance;
                        ?>
                    </li>                                                            
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
            <div class="right-content bg-white">
                <div class="right-review">
                    <div class="rating-block" style="color:gold">
                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                    </div>
                    <?php
                    // Find the distance from the session data
                    $distance = findDistance($row['rs_id']);
                    if ($distance <= 10) {
                        echo "<p style='color:green;margin-right:10px'>Available</p>";
                    } else {
                        echo "<span style='color:Red;'>Currently Unavailable</span>";
                    }
                    ?>
                    <a href="dishes.php?res_id=<?php echo $row['rs_id']; ?>" class="btn theme-btn-dash">View Menu</a>
                </div>
            </div>
        </div>
        <?php
    }

    // End buffering and store the output
    $html = ob_get_clean();

    // Return the HTML as the AJAX response
    echo $html;
} else {
    // Category name not provided
    echo "Error: Category name not provided.";
}

// Function to find the distance from the session data
function findDistance($restaurantId) {
    if(isset($_SESSION['distances'])) {
        $restaurants = $_SESSION['distances'];
        foreach ($restaurants as $res) {
            if ($res['rs_id'] == $restaurantId) {
                return $res['distance'];
            }
        }
    }
    return "Distance not found";
}
?>
