<?php
include('../connection/connect.php'); // Include your database connection file

// Validate the incoming data (restaurantId)
if (isset($_GET['restaurantId'])) {
    $restaurantId = intval($_GET['restaurantId']);

    // Function to fetch tables based on the selected restaurant
    function getTablesByRestaurant($restaurantId, $db) {
        $tables = array();

        // Assuming you have a 'tables' table with columns 'table_id', 'capacity', 'is_booked', 'table_name', 'description'
        $query = "SELECT table_id, table_name FROM tables WHERE rs_id = $restaurantId AND is_booked = 0";
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $tables[] = $row;
        }

        return $tables;
    }

    // Fetch tables for the selected restaurant
    $tables = getTablesByRestaurant($restaurantId, $db);

    // Return the tables in JSON format
    header('Content-Type: application/json');
    echo json_encode($tables);
} else {
    // Invalid or missing restaurantId parameter
    echo json_encode(array('error' => 'Invalid or missing restaurantId parameter.'));
}
?>
