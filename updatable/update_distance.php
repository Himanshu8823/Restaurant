<?php
if (isset($_POST['distance'])) {
    $distance = $_POST['distance'];
    
    // You can use $distance in PHP as needed (e.g., store it in the database)
    // For now, let's just print it
    echo "Distance from user: " . $distance . " km";
} else {
    echo "Invalid request";
}
?>
