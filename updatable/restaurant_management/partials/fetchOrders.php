<?php
// Include database connection
include("../connection/connect.php");

// Initialize response array
$response = array();

// Fetch orders data from the database
$sql = "SELECT * FROM orders";
$result = mysqli_query($db, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $orders = array();

        // Fetch rows and add them to the orders array
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }

        // Set response data
        $response['success'] = true;
        $response['data'] = $orders;
    } else {
        // No orders found
        $response['success'] = false;
        $response['message'] = "No orders found.";
    }
} else {
    // SQL query failed
    $response['success'] = false;
    $response['message'] = "Error fetching orders: " . mysqli_error($db);
}

// Close database connection
mysqli_close($db);

// Return JSON response
echo json_encode($response);
?>
